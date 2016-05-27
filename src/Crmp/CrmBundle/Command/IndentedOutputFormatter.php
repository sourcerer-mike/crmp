<?php
namespace Crmp\CrmBundle\Command;

use Symfony\Component\Console\Formatter\OutputFormatter;

class IndentedOutputFormatter extends OutputFormatter
{
    const INDENT_AMOUNT = 4;

    private $indentLevel = 0;

    /**
     * Formats a message according to the given styles.
     * @param string $message The message to style
     * @return string The styled message
     * @api
     */
    public function format($message)
    {
        $message = parent::format($message);
        if ($this->indentLevel === 0) {
            return $message;
        }

        $amount = self::INDENT_AMOUNT * $this->indentLevel;
        $prependBy = str_repeat(' ', $amount);
        $message = $prependBy . $message;

        return $message;
    }

    /**
     *
     */
    public function increaseLevel()
    {
        $this->indentLevel = $this->indentLevel + 1;
    }

    /**
     *
     */
    public function decreaseLevel()
    {
        $this->indentLevel = $this->indentLevel - 1;
    }
}