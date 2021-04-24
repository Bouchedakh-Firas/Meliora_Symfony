<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

class StatReclamationController extends AbstractController
{
    /**
     * @Route("/stat/reclamation", name="stat_reclamation")
     */
    public function StatAction()
    {
        $pieChart = new PieChart();
        $em = $this->getDoctrine()->getManager();
        $classes = $em->getRepository(Reclamation::class)->findAll();
        $totalReclamation=0;
        foreach($classes as $class) {
            $totalReclamation=$totalReclamation+$class->getStatu();
        }
        $data= array();
        $stat=['Reclamation', 'Statut'];
        $nb=0;
        array_push($data,$stat);
        foreach($classes as $classe) {
            $stat=array();
            array_push($stat,$classe->getSujetReclamation(),(($classe->getStatu()) *100)/$totalReclamation);
            $nb=($classe->getStatu() *100)/$totalReclamation;
            $stat=[$classe->getSujetReclamation(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des Réclamations par Statut');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('Stat_reclamation/Stat.html.twig', array('piechart' =>
            $pieChart));
    }

}
