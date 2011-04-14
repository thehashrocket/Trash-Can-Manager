<?php

/**

 * Created by JetBrains PhpStorm.

 * User: Jason Shultz

 * Date: 3/7/11

 * Time: 8:55 AM

 */

 

class Test extends CI_Controller {



    function __construct()

	{

		parent::__construct();

		$this->load->library('tank_auth');

	}



    function index()

    {





        $this->load->helper('shared_framework');

        $this->load->helper('uagent');

        $this->load->view('/test/test');

    }



    function test2() {

        $data['headerjs'] = $this->gmap->getHeaderJS();

        $data['headermap'] = $this->gmap->getMapJS();

        $this->load->view('/test/test2',$data);

    }



    function test3() {

            $this->gmap->GoogleMapAPI();

            // valid types are hybrid, satellite, terrain, map

            $this->gmap->setMapType('hybrid');

            // you can also addMarkerByCoords($long,$lat)

            // both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename

            $data['headerjs'] = $this->gmap->getHeaderJS();

            $data['headermap'] = $this->gmap->getMapJS();

			$this->load->model('Customer_model');

            $this->gmap->addMarkerByAddress("1406 E Crestwood Dr, Harrison, AR, USA","Marker Title", "Marker Description", $tooltip="", $filename="");



            $this->gmap->addMarkerByAddress("106 E Aspen St, Cottonwood, AZ, USA","Marker Title", "Marker Description", $tooltip="", $filename="");

            $this->gmap->addMarkerByAddress("989 S Main ST, Cottonwood, AZ, USA","Marker Title", "Marker Description", $tooltip="", $filename="");



            $data['headerjs'] = $this->gmap->getHeaderJS();

            $data['headermap'] = $this->gmap->getMapJS();

            $data['onload'] = $this->gmap->printOnLoad();

            //$data['directions'] = $this->gmap->addDirections();

            $data['map'] = $this->gmap->printMap();

            $data['sidebar'] = $this->gmap->printSidebar();

            $data['page_title'] = 'Trash Can Manager - Control Panel';

            $this->load->view('/test/test3',$data);

    }



    function savecoords() {

        $this->load->helper('shared_framework');

        $this->load->helper('uagent');

        $latitude = $this->input->post('latitude');

        $longitude = $this->input->post('longitude');

        $this->load->library('GMap');

        $this->gmap->GoogleMapAPI();

        // valid types are hybrid, satellite, terrain, map

        $this->gmap->setMapType('hybrid');

        //Set Mobile Parameters

        $this->gmap->mobile = true;

        $this->gmap->width = "100%";

        $this->gmap->height = "100%";

        $this->gmap->addMarker($longitude,$latitude);

        $this->gmap->disableSidebar();

        $data['headerjs'] = $this->gmap->getHeaderJS();

        $data['headermap'] = $this->gmap->getMapJS();

        $data['onload'] = $this->gmap->printOnLoad();

        $data['map'] = $this->gmap->printMap();

        $this->load->view('/test/savecoords',$data);

    }



}

