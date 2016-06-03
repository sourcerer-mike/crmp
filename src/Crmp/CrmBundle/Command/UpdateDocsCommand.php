<?php

namespace Crmp\CrmBundle\Command;


use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class UpdateDocsCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    protected $exitCode = 0;

    public function __construct()
    {
        parent::__construct('crmp:docs:update');
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->setFormatter(
            new IndentedOutputFormatter(
                $output->getFormatter()->isDecorated()
            )
        );

        $em = $this->container->get('doctrine.orm.entity_manager');

        // bundles

        $bundles = $this->container->get('kernel')->getBundles();

        foreach ($bundles as $bundle) {
            if (0 !== strpos($bundle->getName(), 'Crmp')) {
                continue;
            }

            if ($output->isVerbose()) {
                $output->writeln($bundle->getName());
                $output->getFormatter()->increaseLevel();
            }

            $this->parseBundle($bundle, $output);
            $this->writeUsage($this->parseUnitTests($bundle, $output), $bundle, $output);

            if ($output->isVerbose()) {
                $output->getFormatter()->decreaseLevel();
            }
        }

        return $this->exitCode;
    }

    private function parseBundle(BundleInterface $bundle, OutputInterface $output)
    {
        if ($output->isVerbose()) {
            $output->writeln('Entities');
            $output->getFormatter()->increaseLevel();
        }

        $this->updateEntities($bundle, $output);

        if ($output->isVerbose()) {
            $output->getFormatter()->decreaseLevel();
        }

    }

    /**
     * @param BundleInterface $bundle
     * @param OutputInterface $output
     */
    private function updateEntities(BundleInterface $bundle, OutputInterface $output)
    {
        $path = $this->getDocPath($bundle);
        $em   = $this->container->get('doctrine.orm.entity_manager');

        foreach ($em->getMetadataFactory()->getAllMetadata() as $meta) {
            /** @var \Doctrine\ORM\Mapping\ClassMetadata $meta */
            if (0 !== strpos($meta->getName(), $bundle->getNamespace())) {
                continue;
            }

            $short = str_replace($bundle->getNamespace().'\\Entity\\', '', $meta->getName());

            if ($output->isVerbose()) {
                $output->writeln($short);
                $output->getFormatter()->increaseLevel();
            }

            $content = $this->parseClassMetadata($bundle, $meta, $output);

            $basename = 'Entities/'.$short.'.md';

            $text    = $this->docToContent($content);
            $details = "\n";

            $text .= "\n## Properties\n\n";
            foreach ($content['fields'] as $field) {
                $text .= '- '.$field['heading']."\n";
                if (trim($field['content'])) {
                    $details .= rtrim($field['content'])."\n\n";
                }
            }

            if (trim($details)) {
                $text .= $details."\n";
            }

            $text = rtrim($text)."\n";

            $docPath = $path.'/'.$basename;

            if ( ! is_dir(dirname($docPath))) {
                if ( ! mkdir(dirname($docPath), 0755, true)) {
                    continue;
                }
            }

            file_put_contents($docPath, $text);

            if ($output->isVerbose()) {
                $output->writeln('Written to: '.$basename);

                $output->getFormatter()->decreaseLevel();
            }
        }
    }

    /**
     * @param BundleInterface $bundle
     *
     * @return string
     */
    private function getDocPath(BundleInterface $bundle)
    {
        return $bundle->getPath().'/Resources/doc';
    }

    private function parseClassMetadata(BundleInterface $bundle, ClassMetadata $meta, OutputInterface $output)
    {
        $reflectionClass = $meta->getReflectionClass();

        if ($output->isVerbose()) {
            $output->writeln('# '.$reflectionClass->getShortName());
        }

        $data = $this->parseDocComment(
            $reflectionClass->getShortName(),
            $reflectionClass->getDocComment(),
            $output
        );

        $data['fields'] = [];

        foreach ($meta->getFieldNames() as $fieldName) {
            if (in_array($fieldName, $meta->getIdentifier())) {
                continue;
            }

            $field = $reflectionClass->getProperty($fieldName);

            if ( ! $field) {
                $this->exitCode++;
                $output->writeln('<error>Unresolvable field "'.$fieldName.'"</error>');
            }

            if ($output->isVerbose()) {
                $output->writeln('- '.$fieldName);
            }

            $data['fields'] = array_merge($data['fields'], $this->extractField($field, $output));
        }

        return $data;
    }

    /**
     * @param string          $slug
     * @param string          $docComment
     * @param OutputInterface $output
     *
     * @return mixed
     */
    private function parseDocComment($slug, $docComment, OutputInterface $output)
    {
        $fieldData = [
            'heading' => '',
            'content' => '',
        ];

        if (preg_match('/@group[\s]*internal/', $docComment)) {
            return null;
        }

        if ( ! $docComment) {
            return $fieldData;
        }

        preg_match('!\/[\s\*]*([^\*]*)\*(.*?(?=\s*\* @|\s*\*\/))!s', $docComment, $headingMatches);

        $fieldData['heading'] = '(missing header)';
        if ($headingMatches && isset( $headingMatches[1] )) {
            $fieldData['heading'] = trim($headingMatches[1]);
        }

        if ( ! $fieldData['heading'] || 0 === strpos($fieldData['heading'], '@')) {
            $this->exitCode++;
            $output->writeln(sprintf('<error>%s has no heading.</error>', $slug));
        }

        if (isset( $headingMatches[2] )) {
            $fieldData['content'] = trim($headingMatches[2]);
            $fieldData['content'] = preg_replace('@\n\s*\* @s', "\n", $fieldData['content']);
            $fieldData['content'] = rtrim($fieldData['content'], "*\n ");
            $fieldData['content'] = substr($fieldData['content'], 2); // cut off "* " from beginning
        }

        if ( ! $fieldData['content']) {
            $this->exitCode++;
            $output->writeln(sprintf('<error>%s has no content.</error>', $slug));
        }

        return $fieldData;
    }

    private function extractField(\ReflectionProperty $field, OutputInterface $output)
    {
        $fieldData = $this->parseDocComment(
            $field->getDeclaringClass()->getName().'::'.$field->getName(),
            $field->getDocComment(),
            $output
        );

        return [$field->getName() => $fieldData];
    }

    /**
     * @param string $docs
     *
     * @return string
     */
    private function docToContent($docs, $level = 1)
    {
        $content = '';

        $heading = ' (missing heading)';
        if (isset( $docs['heading'] ) && $docs['heading']) {
            $heading = rtrim($docs['heading'], '.');
        }

        $content .= str_repeat('#', $level);
        $content .= ' '.$heading."\n\n";

        if (isset( $docs['content'] ) && $docs['content']) {
            $content .= "\n".$docs['content']."\n\n";
        }

        if (isset( $docs['children'] ) && $docs['children']) {
            foreach ($docs['children'] as $child) {
                $content .= $this->docToContent($child, $level + 1);
            }
        }

        return $content;
    }

    private function writeUsage($docs, BundleInterface $bundle, OutputInterface $output)
    {
        $files = [];
        foreach ($docs as $scope => $info) {
            $content = '';

            $shortScope = str_replace($bundle->getNamespace().'\\Tests\\', '', $scope);

            $fileName = str_replace('\\', '/', preg_replace('@Test$@', '.md', $shortScope));
            $filePath = $this->getDocPath($bundle).'/'.$fileName;

            $output->writeln($filePath, $output::VERBOSITY_DEBUG);

            if ( ! is_dir(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            file_put_contents($filePath, $this->docToContent($info));

        }
    }

    private function parseUnitTests(BundleInterface $bundle, OutputInterface $output)
    {
        $output->writeln('Parsing tests ...', $output::VERBOSITY_VERBOSE);

        if ($output->isVerbose()) {
            $output->getFormatter()->increaseLevel();
        }

        $dir = $bundle->getPath().'/Tests';
        $output->writeln($dir, $output::VERBOSITY_DEBUG);

        $finder = new Finder();
        $finder->files()->in($dir)->name('*Test.php');

        $docs = [];
        foreach ($finder as $testFile) {
            /** @var SplFileInfo $testFile */
            $output->writeln($testFile->getRealPath(), $output::VERBOSITY_DEBUG);

            $class = str_replace($bundle->getPath(), '', $testFile->getPath()).'\\'.$testFile->getBasename('.php');
            $class = ltrim($class, '/\\');
            $class = $bundle->getNamespace().'\\'.str_replace('/', '\\', $class);

            if ( ! class_exists($class)) {
                $output->writeln('<comment>Class does not exist: '.$class.'</comment>', $output::VERBOSITY_DEBUG);
            }

            $output->writeln($class, $output::VERBOSITY_VERBOSE);

            $parseClass = $this->parseClass($class, new BufferedOutput());

            if ( ! $parseClass) {
                continue;
            }

            $docs[$class]             = $parseClass;
            $docs[$class]['children'] = $this->parseMethods($class, '@^test(.*)@', new BufferedOutput());
        }

        if ($output->isVerbose()) {
            $output->getFormatter()->decreaseLevel();
        }

        return $docs;
    }

    private function parseClass($class, $output)
    {
        $reflectClass = new \ReflectionClass($class);
        $docComment   = $reflectClass->getDocComment();

        if (preg_match('/@group\s*internal/', $docComment)) {
            // skip internal classes: they shall not be in end-user documentation
            return [];
        }

        $docs             = $this->parseDocComment($class, $docComment, $output);
        $docs['children'] = [];

        return $docs;
    }

    private function parseMethods($class, $pattern, $output)
    {
        $reflectClass = new \ReflectionClass($class);

        $docs = [];

        foreach ($reflectClass->getMethods() as $method) {
            if ( ! preg_match($pattern, $method->getName(), $matches)) {
                continue;
            }

            $docComment = $method->getDocComment();

            if (preg_match('/@group\s*internal/', $docComment)) {
                // skip internal methods: they shall not be in end-user documentation
                continue;
            }

            $docs[$method->getName()] = $this->parseDocComment('::'.$method, $docComment, $output);
        }

        return $docs;
    }

    protected function sortMethods(\ReflectionMethod $methodA, \ReflectionMethod $methodB)
    {
        return ( $methodA->getName() > $methodB->getName() );
    }

    private function extractHeading(\ReflectionClass $reflectionClass)
    {
        $docComment = $reflectionClass->getDocComment();

        preg_match('@\/[\s\*]*([^\*]*)@s', $docComment, $headingMatches);

        if ( ! $headingMatches || ! isset( $headingMatches[1] )) {
            return '';
        }

        return trim($headingMatches[1]);
    }

    /**
     * @param $basename
     *
     * @return mixed
     */
    private function sanitizeName($basename)
    {
        $basename = strtr(
            $basename,
            [
                ' ' => '-',
            ]
        );
        $basename = preg_replace('@[^a-z\-\_]@i', '', $basename);

        return $basename;
    }

    private function updateController(BundleInterface $bundle, OutputInterface $output)
    {
        // Fetch all controller.
        $controllerDirectory = $bundle->getPath().'/Controller';
        if (file_exists($controllerDirectory)) {
            foreach (glob($controllerDirectory.'/*Controller.php') as $controllerFile) {

                $controllerClass = $bundle->getNamespace()
                                   .'\\Controller\\'
                                   .basename($controllerFile, '.php');

                if ( ! class_exists($controllerClass)) {
                    if ($output->isDebug()) {
                        $output->writeln('Skipping controller file '.basename($controllerFile));
                    }
                    continue;
                }

                if ($output->isDebug()) {
                    $output->writeln('Parsing controller '.$controllerClass);
                }

                if ($output->isVerbose()) {
                    $output->writeln($controllerClass);
                    $output->getFormatter()->increaseLevel();
                }

                $this->writeControllerDocs(
                    basename($controllerFile, 'Controller.php'),
                    $this->parseController($controllerClass, $output),
                    $bundle,
                    $output
                );


                if ($output->isVerbose()) {
                    $output->getFormatter()->decreaseLeveL();
                }
            }
        }
    }

    private function writeControllerDocs($slug, $docs, BundleInterface $bundle, OutputInterface $output)
    {
        $content = $this->docToContent($docs);

        foreach ($docs['actions'] as $actionDoc) {
            $content .= $this->docToContent($actionDoc, 2);
            $content .= "\n\n";
        }

        $docDir = $this->getDocPath($bundle).'/Controller';

        if ( ! is_dir($docDir)) {
            mkdir($docDir, 0755, true);
        }

        file_put_contents($docDir.'/'.$slug.'.md', $content);
    }

    /**
     * @param string          $controllerClass
     * @param OutputInterface $output
     *
     * @return array
     */
    private function parseController($controllerClass, OutputInterface $output)
    {
        $controllerReflection = new \ReflectionClass($controllerClass);

        $docs            = $this->parseDocComment($controllerClass, $controllerReflection->getDocComment(), $output);
        $docs['actions'] = [];

        $reflectionMethods = $controllerReflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        usort($reflectionMethods, [$this, 'sortMethods']);

        foreach ($reflectionMethods as $method) {
            $methodName = $method->getName();

            if ( ! preg_match('@Action$@', $methodName)) {
                if ($output->isDebug()) {
                    $output->writeln('Skipping '.$methodName.' - not an action.');
                }
                continue;
            }

            if ($output->isVerbose()) {
                $output->writeln('::'.$methodName);
            }

            $docs['actions']['::'.$methodName] = $this->parseDocComment(
                '::'.$methodName,
                $method->getDocComment(),
                $output
            );
        }

        return $docs;
    }
}