<?php

namespace App\Controller;

use App\Entity\BaseEmail;
use App\Entity\AdresseToAffich;
use App\Entity\TextToSave;
use App\Services\FileUploader;
use App\Services\WithoutSpecialCharcat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
//
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class EmailerController extends AbstractController
{
    #[Route('/', name: 'emailer')]
    public function index(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer, WithoutSpecialCharcat $withoutSPChar): Response
    {
            if($request->request->get('etat')==='test'){
                $adr1=[];
                $adr4=[];
                //envoi email de test
                $adr1[] = 'vincentnguyen332@gmail.com';
                $adr1[]= 'vincentphuhan.nguyen@neuf.fr';
                $adr1[]= 'contact@pmualgomath.com';
                $adr1[]= 'contact@deltaprojetdigital.net';
                $adr1[]= 'conseil@deltaprojetdigital.net';

                foreach($adr1 as $single){
                    //dd($single);
                    $courr= $withoutSPChar->replace($single);
                    
                    $etat = $this->mailing($mailer, $courr);
                     //ici ajoutez $courr en table
                     $AdresseNumber = new AdresseToAffich;
                     $AdresseNumber->setAdresse($courr.'-');
                     $entityManager = $doctrine->getManager();
                     $entityManager->persist($AdresseNumber);
                     $entityManager->flush();

                    if(!$etat){
                    $adr4[]=$courr;
                    }
                }
                $reussiteEmail = $doctrine->getRepository(AdresseToAffich::class);
                $adr2 = $reussiteEmail->findAll();
                $text = $doctrine->getRepository(TextToSave::class);
                $text0 = $text->findLast();
                $text1= $text0->getContenu();
                $this->addFlash(
                    'messageError', 'Vous avez envoyé un email de test...'
                );

                return $this->render('emailing/index.html.twig', [
                    'controller_name' => 'EmailerController',
                    'text'=>$text1,
                    'tab'=>$adr2,
                    'refus'=>$adr4,
                ]);
                
            } elseif($request->request->get('etat')==='all') {
		        $adr4=[];
		
                $limitBasse=(int)($request->request->get('first'));
                $limitHaute=(int)($request->request->get('end'));
                $text1 = $request->request->get('text');

                $baseRepository = $doctrine->getRepository(BaseEmail::class);
                $user = $baseRepository->findByLimits($limitBasse, $limitHaute);
                //envoi de tous les emails
                foreach($user as $single){
                    //dd($single);
                    $courr= $withoutSPChar->replace($single->getAdresse());
                    $etat = $this->mailing($mailer, $courr);
                    //ici ajoutez $courr en table
                    $AdresseNumber = new AdresseToAffich;
                    $AdresseNumber->setAdresse($courr.'-'.$single->getNumber());
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($AdresseNumber);
                    $entityManager->flush();

                    if(!$etat){
                    $adr4[]=$courr;
                    }
                }
                $reussiteEmail = $doctrine->getRepository(AdresseToAffich::class);
                $adr2 = $reussiteEmail->findAll();
                $text = $doctrine->getRepository(TextToSave::class);
                $text0 = $text->findLast();
                $text1= $text0->getContenu();
                //message reussite
                $this->addFlash(
                    'messageError', 'Vous avez envoyé un email à tous les users'
                );
                //dd($adr2);
                return $this->render('emailing/index.html.twig', [
                    'controller_name' => 'EmailerController',
                    'text'=>$text1,
                    'tab' => $adr2,
                    'refus'=>$adr4,
                ]);
            }
            elseif($request->request->get('etat')==='text') {
                $textToUpdate = $request->request->get('text');
                $text = $doctrine->getRepository(TextToSave::class);
                $text0 = $text->findLast();
                $text0->setContenu($textToUpdate);
                $entityManager = $doctrine->getManager();
                $entityManager->persist($text0);
                $entityManager->flush();
                $text1 = $text0->getContenu();
            }
            $reussiteEmail = $doctrine->getRepository(AdresseToAffich::class);
            $adr2 = $reussiteEmail->findAll();
            $text = $doctrine->getRepository(TextToSave::class);
            $text0 = $text->findLast();
            $text1 = $text0->getContenu();
            $adr4=[];
            return $this->render('emailing/index.html.twig', [
                'controller_name' => 'EmailerController',
                'text'=>$text1,
                'tab'=>$adr2,
                'refus'=>$adr4,
            ]);
    }
    
    /**
	* @Route("/emailer/send", name="email-sender")
	*/
	public function mailing($mailer, $email1): bool
	{
        $email = (new TemplatedEmail())
        ->from('mail@12a4f5g85420b.pmualgomath.com')
        ->to($email1)
        ->subject('PmuAlgoMath, un prono par vous-même')
        //->attach(fopen('/path/to/documents/contract.doc', 'r'))
        // pass variables (name => value) to the template
        /*->context([
            'expiration_date' => new \DateTime('+7 days'),
            'username' => 'foo',
        ]);*/
        ->context([
        ])
        // path of the Twig template to render
        ->htmlTemplate('emailing/courriel.html.twig');
        	//dd($email);
		try {
		    $mailer->send($email);
		} catch (TransportExceptionInterface $e) {
	    	return false;
		}
        return true;
	}
     #[Route('/listEmail/listing-email', name: 'list-email')]
    public function listEmails():Response
    {
        return $this->render('listEmail/listEmails.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/listEmail/listing-email-source-all', name: 'list-email-source-all')]
    public function listEmailsSource(Request $request, ManagerRegistry $doctrine, WithoutSpecialCharcat $withoutSPChar):Response
    {
        
        $baserepository = $doctrine->getRepository(BaseEmail::class);
        $baseByRepository = $baserepository->findAll();
        $arrayEmail=[];
        //dd($baseByRepository);
	foreach($baseByRepository as $single){
        //dd($single);
        $courr= $withoutSPChar->replace($single->getAdresse());
            $arrayEmail[]= $courr;
        }
        return $this->render('listEmail/listEmailSource.html.twig', [
            'controller_name' => 'AdminController',
            'base_email' => $arrayEmail,
        ]);
    }
    #[Route('/listEmail/add-file-list-email', name: 'add-file-list-email')]
    public function addFileEmailsToSource(Request $request, ManagerRegistry $doctrine, string $uploadDir,
    FileUploader $uploader)
    {
        if($request->isMethod('POST')){
            $submittedToken = $request->request->get('token');
            
            $file = $request->files->get('myfile');

            if (empty($file))
            {
                $this->addFlash(
                    'messageError',
                    'Fichier vide ou trop volumineux'
                );
            return $this->redirectToRoute("list-email");
            }
            //upload du fichier
            $filename = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());
            $extOk = array('txt');
            

            if(!in_array($extension, $extOk)){
                $this->addFlash(
                    'messageError',
                    'mauvaise extension ou fichier vide'
                );
                return $this->redirectToRoute("list-email");
            }
            $uploader->upload($uploadDir, $file, $filename);
            //lecture du fichier
            $finder = new Finder();
            $fileToList = $finder->files()->name($filename);
            // Nom du fichier à ouvrir
            $fichier = file($uploadDir.'/'.$filename);
            //on initialise le nombre à 14840
            $i=14840;
            // on parcourt ligne par ligne
            foreach ($fichier as $line_num => $line) {

                $linecorrect= str_replace("\n", "", $line);
                $baserepository = $doctrine->getRepository(BaseEmail::class);
                $baseByRepository = $baserepository->findAll();

                $ok="no";
                foreach($baseByRepository as $baseR)
                {
                    if($baseR->getAdresse()===$linecorrect)
                    {
                        $ok="OK";
                    }
                }
                if($ok === "no"){
                    
                    $baseemail = new BaseEmail;
                    $baseemail->setAdresse($linecorrect);
                    $baseemail->setNumber($i);
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($baseemail);
                    $entityManager->flush();
                    $i++;
                }
               
            }
            $filesystem = new Filesystem();
            $path = ('../public/images/'.$filename);
            //dd($path);
            $filesystem->remove([$path]);

            $this->addFlash(
                'messageError',
                'Le contenu du fichier a été ajouté'
            );

            return $this->redirectToRoute("list-email");
        }
        $this->addFlash(
            'messageError',
            'erreur Grave'
        );
        return $this->redirectToRoute("list-email");
    }
    #[Route('/addFacebook/listing-email', name: 'add-facebook-landing')]
    public function listFacebookSource(Request $request):Response
    {
        $statu="";
        if($request->isMethod('POST')){
            $submittedToken = $request->request->get('token');
            $statu="";
        }
        return $this->render('AddFacebook/addFacebook.html.twig', [
            'stat'=>$statu,
        ]);
    }
    #[Route('/listEmail/add-file-facebook-email', name: 'add-file-list-facebook-email')]
    public function addFileFacebookToSource(Request $request, ManagerRegistry $doctrine, string $uploadDir,
    FileUploader $uploader, WithoutSpecialCharcat $withoutSPChar)
    {
        if($request->isMethod('POST')){
            $file = $request->files->get('myfile');

            if (empty($file))
            {
                $this->addFlash(
                    'messageError',
                    'Fichier vide ou trop volumineux'
                );

            return $this->redirectToRoute("add-facebook-landing");
            }
            //upload du fichier
            $filename = $file->getClientOriginalName();
            
            $var = $uploader->upload($uploadDir, $file, $filename);
            //pour regarder une erreur
            //dd($var);
            //lecture du fichier
            $finder = new Finder();
            $fileToList = $finder->files()->name($filename);
            // Nom du fichier à ouvrir
            $fichier = file($uploadDir.'/'.$filename);
            //on initialise le nombre à 14840 (14840[scrappés])-(210253)
            $i=210254;
            // on parcourt ligne par ligne
            foreach ($fichier as $line_num => $line) {
                // Exemple 1
                //la on prend le prenom et le nom
                $var = explode(",", $line);
                $prenom = str_replace(" ", "", $var[2]);
                $prenom= $withoutSPChar->replace($prenom);
                $nom = str_replace(" ", "", $var[3]);
                $nom= $withoutSPChar->replace($nom);
                $adress1 = $prenom.'.'.$nom.'@gmail.com';
                /*$adress2 = $prenom.'.'.$nom.'@outlook.com';
                $adress3 = $prenom.'.'.$nom.'@hotmail.fr';
                $adress4 = $prenom.'.'.$nom.'@hotmail.com';
                $adress5 = $prenom.'.'.$nom.'@yahoo.com';*/

                //for($v=1;$v<6;$v++){
                    $baserepository = $doctrine->getRepository(BaseEmail::class);
                    //$baseByRepository = $baserepository->findByAdresse(${'adress'.$v});
                    $baseByRepository = $baserepository->findByAdresse($adress1);
                    if(!$baseByRepository){
                   // if(!$baseByRepository[0]){
                        $baseemail = new BaseEmail;
                        //$baseemail->setAdresse(${'adress'.$v});
                        $baseemail->setAdresse(${'adress1'});
                        $baseemail->setNumber($i);
                        $entityManager = $doctrine->getManager();
                        $entityManager->persist($baseemail);
                        $entityManager->flush();
                        $i++;
                   // }
                    }
                //}
               
            }
            $filesystem = new Filesystem();
            $path = ('../public/images/'.$filename);
            //dd($path);
            $filesystem->remove([$path]);

            $this->addFlash(
                'messageError',
                'Le contenu du fichier a été ajouté'
            );
            return $this->redirectToRoute("list-email");
        }
        $this->addFlash(
            'messageError',
            'erreur Grave'
        );
        return $this->redirectToRoute("list-email");
    }
    #[Route('/purge-adress', name: 'purge-adress')]
    public function purge(Request $request, ManagerRegistry $doctrine):Response
    {
        
        $entityManager = $doctrine->getManager();
        $toRemove = $entityManager->getRepository(AdresseToAffich::class)->findAll();
        //dd($toRemove);
        foreach($toRemove as $rem){
            //dd($rem);
            $entityManager->remove($rem);
            $entityManager->flush();
        }
        return $this->redirectToRoute("emailer");
    }
}

