<?php

namespace Crmp\CrmBundle\Command;


use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class UpdateDocsCommand extends Command implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

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

            if ($output->isVerbose()) {
                $output->getFormatter()->decreaseLevel();
            }
        }

        return;
    }

    private function parseBundle(BundleInterface $bundle, OutputInterface $output)
    {
        $path = $bundle->getPath().'/Resources/doc';

        $em = $this->container->get('doctrine.orm.entity_manager');

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

            $text    = '';
            $details = "\n";
            $text .= '# '.$content['heading']."\n\n";

            if (trim($content['content'])) {
                $text .= $content['content'] . "\n\n";
            }

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

    private function parseClassMetadata(BundleInterface $bundle, ClassMetadata $meta, OutputInterface $output)
    {
        $reflectionClass = $meta->getReflectionClass();

        if ($output->isVerbose()) {
            $output->writeln('# '.$reflectionClass->getShortName());
        }

        $data           = $this->parseDocComment(
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

        preg_match('!\/[\s\*]*([^\*]*)\*(.*?(?=\s*\* @))!s', $docComment, $headingMatches);

        if ($headingMatches && isset( $headingMatches[1] )) {
            $fieldData['heading'] = trim($headingMatches[1]);
        }

        if ( ! $fieldData['heading'] || 0 === strpos($fieldData['heading'], '@')) {
            $output->writeln(sprintf('<error>%s has no heading.</error>', $slug));
        }

        if (isset( $headingMatches[2] )) {
            $fieldData['content'] = trim($headingMatches[2]);
            $fieldData['content'] = preg_replace('@\n\s*\* @s', "\n", $fieldData['content']);
            $fieldData['content'] = rtrim($fieldData['content'], "*\n ");
            $fieldData['content'] = substr($fieldData['content'], 2); // cut off "* " from beginning
        }

        if ( ! $fieldData['content']) {
            $output->writeln(sprintf('<error>%s has no content.</error>', $slug));
        }

        return $fieldData;
    }

    private function extractField(\ReflectionProperty $field, OutputInterface $output)
    {
        $fieldData = $this->parseDocComment(
            $field->getDeclaringClass()->getName() . '::' . $field->getName(),
            $field->getDocComment(),
            $output
        );

        return [$field->getName() => $fieldData];
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
}