<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Option;
use App\Form\EtudiantType;
use App\Form\RechdecType;
use App\Repository\EtudiantRepository;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/etudiant')]
class EtudiantController extends AbstractController
{
    #[Route('/', name: 'app_etudiant_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($etudiant);

            $bacFile = $form->get('bac')->getData();

            // this condition is needed because the 'bac' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($bacFile) {

                $originalFilename = pathinfo($bacFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$bacFile->guessExtension();

                // Move the file to the directory where bacs are stored
                try {
                    $bacFile->move(
                        $this->getParameter('bac_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo "Mal partir";
                    // ... handle exception if something happens during file upload
                }

                // updates the 'bacFilename' property to store the PDF file name
                // instead of its contents
                $etudiant->setBac($newFilename);
            }
            // dd($etudiant);
            $entityManager->persist($etudiant);
            $entityManager->flush();
            $this->addFlash('success','enregistrement éffectué avec succès');
            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/recherche', name: 'app_etudiant_option', methods: ['GET', 'POST'])]
    public function rech(
        Request $request,
        OptionRepository $optionRepository,
        EtudiantRepository $etudiantRepository
    ): Response
    {
        $etu = null;
        
        $form = $this->createForm(RechdecType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $opt = $form->get('opt')->getData();
            $etu = $etudiantRepository->findBy(['codopt' => $opt]);   
            // dd($etu);
        }

        return $this->render('etudiant/recherche_dec.html.twig', [
            'etu' => $etu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success','enregistrement modifié avec succès');
            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_etudiant_delete', methods: ['POST','GET'])]
    public function delete(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        
        if($etudiant->getBac()){
            $filesystem = new Filesystem();
            $file=$etudiant->getBac();
            $FilePath =$this->getParameter('bac_directory') . '/' . $file;                
            // dd($FilePath);
            try {
                $filesystem->remove($FilePath);
            } catch (\Exception $e) {
                echo "Mal partir";
            }
        }

        $entityManager->remove($etudiant);
        $entityManager->flush();
        $this->addFlash('error','enregistrement supprimé avec succes');
        return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
    }    
}
