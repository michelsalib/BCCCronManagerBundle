<?php

namespace BCC\CronManagerBundle\Controller;

use \Symfony\Component\Serializer\Encoder\JsonEncoder;
use \Symfony\Component\Serializer\Serializer;
use \Symfony\Component\HttpFoundation\Response;
use \BCC\CronManagerBundle\Form\Type\CronType;
use \BCC\CronManagerBundle\Manager\Cron;
use \BCC\CronManagerBundle\Manager\CronManager;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * Displays the current crons and a form to add a new one.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function indexAction()
    {
        $cm = new CronManager();
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());

        $form = $this->createForm(new CronType(), new Cron());

        return $this->render('BCCCronManagerBundle:Default:index.html.twig', array(
            'crons' => $cm->get(),
            'raw'   => $cm->getRaw(),
            'form'  => $form->createView(),
        ));
    }

    /**
     * Add a cron to the cron table
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function addAction()
    {
        $cm = new CronManager();
        $cron = new Cron();
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());
        $form = $this->createForm(new CronType(), $cron);

        $request = $this->get('request');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $cm->add($cron);
            $this->addFlash('message', $cm->getOutput());
            $this->addFlash('error', $cm->getError());

            return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
        }

        return $this->render('BCCCronManagerBundle:Default:index.html.twig', array(
            'crons' => $cm->get(),
            'raw'   => $cm->getRaw(),
            'form'  => $form->createView(),
        ));
    }

    /**
     * Edit a cron
     *
     * @param $id The line of the cron in the cron table
     * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse|\Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function editAction($id)
    {
        $cm = new CronManager();
        $crons = $cm->get();
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());
        $form = $this->createForm(new CronType(), $crons[$id]);

        $request = $this->get('request');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $cm->write();

            $this->addFlash('message', $cm->getOutput());
            $this->addFlash('error', $cm->getError());

            return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
        }

        return $this->render('BCCCronManagerBundle:Default:edit.html.twig', array(
            'form'  => $form->createView(),
        ));
    }

    /**
     * Wake up a cron from the cron table
     *
     * @param $id The line of the cron in the cron table
     * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
     */
    public function wakeupAction($id)
    {
        $cm = new CronManager();
        $crons = $cm->get();
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());
        $crons[$id]->setSuspended(false);
        $cm->write();
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());

        return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
    }

    /**
     * Suspend a cron from the cron table
     *
     * @param $id The line of the cron in the cron table
     * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
     */
    public function suspendAction($id)
    {
        $cm = new CronManager();
        $crons = $cm->get();
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());
        $crons[$id]->setSuspended(true);
        $cm->write();
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());

        return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
    }

    /**
     * Remove a cron from the cron table
     *
     * @param $id The line of the cron in the cron table
     * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
     */
    public function removeAction($id)
    {
        $cm = new CronManager();
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());
        $cm->remove($id);
        $this->addFlash('message', $cm->getOutput());
        $this->addFlash('error', $cm->getError());

        return $this->redirect($this->generateUrl('BCCCronManagerBundle_index'));
    }

    /**
     * Gets a log file
     *
     * @param $id The line of the cron in the cron table
     * @param $type The type of file, log or error
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function fileAction($id, $type)
    {
        $cm = new CronManager();
        $crons = $cm->get();
        $cron = $crons[$id];

        $data = array();
        $data['file'] =  ($type == 'log') ? $cron->getLogFile(): $cron->getErrorFile();
        $data['content'] = \file_get_contents($data['file']);

        $serializer = new Serializer(array(), array('json' => new JsonEncoder()));

        return new Response($serializer->serialize($data, 'json'));
    }

    /**
     * Adds a flash to the flash bag where flashes are array of messages
     *
     * @param $type
     * @param $message
     * @return mixed
     */
    protected function addFlash($type, $message)
    {
        if ('' == $message || null === $message) {
            return;
        }

        /* @var $session \Symfony\Component\HttpFoundation\Session */
        $session = $this->get('session');

        $session->getFlashBag()->add($type, $message);
    }
}
