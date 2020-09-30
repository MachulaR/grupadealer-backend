<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\User;
use App\Exception\UserNotExistException;
use App\Form\NotificationType;
use App\Service\NotificationService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends AbstractFOSRestController
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @Rest\Post("/notification/send")
     * @Method({"POST"})
     * @return Response
     */
    public function sendNotification(Request $request)
    {
        $notification = new Notification();

        $form = $this->createForm(NotificationType::class, $notification);
        $data = (array) json_decode($request->getContent());

        if (!(empty($data['message']) || empty($data['logins']))) {
            $form->submit($data);
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $this->notificationService->sendNotifications($notification->getMessage(), $notification->getLogins());
                    $viewData = [
                        'status' => '200',
                        'message' => 'OK',
                    ];
                } catch (\Exception $exception) {
                    $viewData = [
                        'status' => '400',
                        'message' => $exception->getMessage(),
                    ];
                }
            }
        } else {
            $viewData = [
                'status' => '400',
                'message' => 'Error! Data incompleted!',
            ];
        }

        return $this->handleView($this->view($viewData));
    }


}
