<?php

namespace BCC\CronManagerBundle\Twig;

class TwigExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    protected $wwwUser;

    /**
     * @var string
     */
    protected $logDir;

    /**
     * @var string
     */
    protected $symfonyCommand;

    public function __construct($logDir, $kernelDir)
    {
        $this->wwwUser = \posix_getpwuid(\posix_geteuid());
        $this->logDir = $logDir;
        $this->symfonyCommand = 'php '.$kernelDir.'/console';
    }
    
    public function getGlobals()
    {
        return array(
            'wwwUser' => $this->wwwUser,
            'logDir' => $this->logDir,
            'symfonyCommand' => $this->symfonyCommand,
        );
    }

    public function getName() {
        return 'bcc-cron-manager';
    }
}
