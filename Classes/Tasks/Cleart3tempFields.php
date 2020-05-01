<?php

namespace Sng\Additionalscheduler\Tasks;

/*
 * This file is part of the "additional_scheduler" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

class Cleart3tempFields extends \Sng\Additionalscheduler\AdditionalFieldProviderInterface
{
    public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject)
    {
        if (empty($taskInfo['additionalscheduler_nbdays'])) {
            if ($parentObject->CMD == 'edit') {
                $taskInfo['additionalscheduler_nbdays'] = $task->nbdays;
            } else {
                $taskInfo['additionalscheduler_nbdays'] = '';
            }
        }
        if (empty($taskInfo['additionalscheduler_dirfilter'])) {
            if ($parentObject->CMD == 'edit') {
                $taskInfo['additionalscheduler_dirfilter'] = $task->dirfilter;
            } else {
                $taskInfo['additionalscheduler_dirfilter'] = '';
            }
        }
        $additionalFields = [];
        $fieldID = 'task_nbdays';
        $fieldCode = '<input type="text" name="tx_scheduler[additionalscheduler_nbdays]" id="' . $fieldID . '" value="' . $taskInfo['additionalscheduler_nbdays'] . '" size="50" />';
        $additionalFields[$fieldID] = [
            'code'     => $fieldCode,
            'label'    => 'LLL:EXT:additional_scheduler/Resources/Private/Language/locallang.xlf:nbdays',
            'cshKey'   => 'additional_scheduler',
            'cshLabel' => $fieldID
        ];
        $fieldID = 'task_dirfilter';
        $fieldCode = '<input type="text" name="tx_scheduler[additionalscheduler_dirfilter]" id="' . $fieldID . '" value="' . $taskInfo['additionalscheduler_dirfilter'] . '" size="50" />';
        $additionalFields[$fieldID] = [
            'code'     => $fieldCode,
            'label'    => 'LLL:EXT:additional_scheduler/Resources/Private/Language/locallang.xlf:dirfilter',
            'cshKey'   => 'additional_scheduler',
            'cshLabel' => $fieldID
        ];
        return $additionalFields;
    }

    public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject)
    {
        $result = true;
        if (!isset($submittedData['additionalscheduler_nbdays'])) {
            $parentObject->addMessage($GLOBALS['LANG']->sL('LLL:EXT:additional_scheduler/Resources/Private/Language/locallang.xlf:nbdayserror'), \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
            $result = false;
        }
        return $result;
    }

    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task)
    {
        $task->nbdays = $submittedData['additionalscheduler_nbdays'];
        $task->dirfilter = $submittedData['additionalscheduler_dirfilter'];
    }
}