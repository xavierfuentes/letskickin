<?php

namespace Application\Letskickin\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Exception\ModelManagerException;

use Application\Letskickin\CoreBundle\Doctrine\PotManager;

class PotAdminController extends CRUDController
{
    protected $eventsActive = false;

    /**
     * @return PotManager
     */
    protected function getPotManager()
    {
        return $this->container->get('letskickin.manager.pot');
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Controller.CRUDController::createAction()
     */
    public function createAction()
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $pot = $this->getPotManager()->createPot($this->eventsActive);

        $this->admin->setSubject($pot);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($pot);

        if ($this->getRestMethod() == 'POST') {
            $form->bind($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $this->getPotManager()->savePot($pot, $this->eventsActive);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                        'result' => 'ok',
                        'objectId' => $this->admin->getNormalizedIdentifier($pot)
                    ));
                }

                $this->addFlash('sonata_flash_success','flash_create_success');
                // redirect to edit mode
                return $this->redirectTo($pot);
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', 'flash_create_error');
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form'   => $view,
            'object' => $pot,
        ));
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Controller.CRUDController::showAction()
     */
    public function showAction($id = null)
    {
        $result = parent::showAction($id);

        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Controller.CRUDController::editAction()
     */
    public function editAction($id = null)
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $this->get('request')->get($this->admin->getIdParameter());

        $pot = $this->getPotManager()->find($id);

        if (!$pot) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $pot)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($pot);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($pot);

        if ($this->getRestMethod() == 'POST') {
            $form->bind($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $this->getPotManager()->updatePot($pot, $pot->getStatus(), $this->eventsActive);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                        'result'    => 'ok',
                        'objectId'  => $this->admin->getNormalizedIdentifier($pot)
                    ));
                }

                $this->addFlash('sonata_flash_success', 'flash_edit_success');

                // redirect to edit mode
                return $this->redirectTo($pot);
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', 'flash_edit_error');
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'edit',
            'form'   => $view,
            'object' => $pot,
        ));
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Controller.CRUDController::deleteAction()
     */
    public function deleteAction($id = null)
    {
        $id     = $this->get('request')->get($this->admin->getIdParameter());
        $pot    = $this->getPotManager()->find($id);

        if (!$pot) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('DELETE', $pot)) {
            throw new AccessDeniedException();
        }

        if ($this->getRestMethod() == 'DELETE') {
            // check the csrf token
            $this->validateCsrfToken('sonata.delete');

            try {
                // $this->admin->delete($pot);
                $this->getPotManager()->updatePot($pot, $pot::STATUS_INACTIVE, $this->eventsActive);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'ok'));
                }

                $this->addFlash('sonata_flash_success', 'flash_delete_success');

            } catch (ModelManagerException $e) {

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'error'));
                }

                $this->addFlash('sonata_flash_error', 'flash_delete_error');
            }

            return new RedirectResponse($this->admin->generateUrl('list'));
        }

        return $this->render($this->admin->getTemplate('delete'), array(
            'object'     => $pot,
            'action'     => 'delete',
            'csrf_token' => $this->getCsrfToken('sonata.delete')
        ));
    }
}
