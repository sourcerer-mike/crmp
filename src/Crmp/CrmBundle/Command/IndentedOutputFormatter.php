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
        if ($this->getLevel() == 0) {
            return $message;
        }

        $amount = self::INDENT_AMOUNT * $this->getLevel();
        $prependBy = str_repeat(' ', $amount);
        $message = $prependBy . $message;

        return $message;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->indentLevel;
    }

    /**
     *
     */
    public function increaseLevel()
    {
        $this->indentLevel = $this->getLevel() + 1;
    }

    /**
     * Decrease indent.
     *
     * Decreases the indent but never lower than zero.
     */
    public function decreaseLevel()
    {
        $this->indentLevel = max(0, $this->getLevel() - 1);
    }
}