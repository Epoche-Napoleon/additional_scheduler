<?php

namespace Sng\Additionalscheduler\Tasks;

/*
 * This file is part of the "additional_scheduler" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Sng\Additionalscheduler\BaseEmailTask;

class SavewebsiteTask extends BaseEmailTask
{
    public function execute()
    {
        require_once(PATH_site . 'typo3conf/ext/additional_scheduler/Classes/Utils.php');

        // exec SH
        $saveScript = PATH_site . 'typo3conf/ext/additional_scheduler/Resources/Shell/save_typo3_website.sh';
        $cmd = $saveScript . ' -p ' . PATH_site . ' -o ' . $this->path . ' -f';
        $return = shell_exec($cmd . ' 2>&1');

        // mail
        $mailTo = $this->email;
        $mailBody = $cmd . LF . LF . $return;
        $mailSubject = $this->subject ?: $this->getDefaultSubject('savewebsite');

        if (empty($this->email) !== true) {
            \Sng\Additionalscheduler\Utils::sendEmail($mailTo, $mailSubject, $mailBody, 'plain', 'utf-8');
        }

        return true;
    }

    public function getAdditionalInformation()
    {
        return $this->path;
    }
}