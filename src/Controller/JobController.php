<?php

namespace App\Controller;

use App\Form\JobType;
use App\Entity\JobPost;
use App\Services\FileUploader;
use App\Repository\JobPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/job", name="job.")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(JobPostRepository $jobPost): Response
    {   
        $jobs = $jobPost->findAll();

        return $this->render('job/index.html.twig', [
            'jobs' => $jobs
        ]);
    }
    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, FileUploader $fileUploader)
    {
        $job = new JobPost();
        $form = $this->createForm(JobType::class,$job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /**
             * @var UploadedFile $file
             */
            $file = $request->files->get('job')['attachment'];

            if($file){
               $fileName = $fileUploader->uploadFile($file);
               $job->setImage($fileName);
               $em->persist($job);
               $em->flush();
            }
            
            return $this->redirect($this->generateUrl('job.index'));
        }
        return $this->render('job/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
   /**
     * @Route("/show/{id}", name="show")
     */
    //we can use it JobPost $job
    public function show(JobPost $job)
    {   
        // $job = $jobPostRepository->findJobByCategory($id);
        return $this->render('job/show.html.twig', [
            'job' => $job
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(JobPost $job)
    {   
        $em = $this->getDoctrine()->getManager();
        $em->remove($job);
        $em->flush();
        $this->addFlash('success','Job deleted successfully');
        return $this->redirect($this->generateUrl('job.index'));
    }
}
