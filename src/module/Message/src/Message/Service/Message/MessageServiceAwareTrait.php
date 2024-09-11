<?php

namespace Message\Service\Message;

trait MessageServiceAwareTrait {

    private MessageService $messageService;

    public function getMessageService(): MessageService
    {
        return $this->messageService;
    }

    /**
     * @param MessageService $messageService
     *
     * @return MessageService
     */
    public function setMessageService(MessageService $messageService): MessageService
    {
        $this->messageService = $messageService;
        return $this->messageService;
    }


}