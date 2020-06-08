<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Form\SondageNewType;
use App\Repository\SondageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;

class SondageController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var SondageRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, Security $security, SondageRepository $repository)
    {
        $this->em = $em;
        $this->security = $security;
        $this->repository = $repository;
    }

    /**
     * @Route("/sondages", name="sondage.index")
     */
    public function index(SondageRepository $SRep)
    {
        $sondages = $SRep->findAll();
        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondages
        ]);
    }

    /**
     * @Route("/sondage/new", name="sondage.new")
     */
    public function create(Request $request)
    {
        $sondage = new Sondage;
        $form = $this->createForm(SondageNewType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $sondage->setCreatedDate(new \DateTime("now"));
            $this->em->persist($sondage);
            $this->em->flush();
            $this->addFlash('success','Sondage "'.$sondage->getTitle().'" bien créé !');
            return $this->redirectToRoute('sondage.index');
        }

        return $this->render('sondage/new.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/sondage/{id}-{cpt}", name="sondage.start")
     */
    public function start($id, $cpt)
    {
        $sondage = $this->repository->find($id);
        return $this->render('sondage/start.html.twig', [
            'sondage' => $sondage,
            'cpt' => $cpt
        ]);
    }

    /**
     * @Route("/sondage_delete/{id}", name="sondage.delete")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function delete($id)
    {
        dump($id);
    }
}
