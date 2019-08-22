<?php
/*
|--------------------------------------------------------------------------
| @Filename: content.php
|--------------------------------------------------------------------------
| @Desc    : Content
| @Date    : 2012-06-16
| @Version : 1.0
| @By      : gabriela.kartika@gmail.com
|
|
|
| @Modified By  :
| @Modified Date:
*/

class Content extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		//loaders here ;-)
		$this->load->database();

		//misc
		$this->load->helper('misc');

		//more

	}

    /**
	| @name
	|      - artikel
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function artikel($page=0)
	{

        $page = addslashes(trim($page));
        $total_row = PER_PAGE;

	    $this->load->model('Artikel_model');
        $res = $this->Artikel_model->get(array(

                                                        'where' => ' AND display = 1',
                                                        'order' => ' order by created_date desc',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/artikel/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '';
        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'artikel',
					  @rawurlencode("$row->artikel_id"),
					  url_title("$row->artikel_title"),
					  );

        $list .= '<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->artikel_title.'</a></h4>
        <h6 class="text-muted">'.substr($row->created_date,0,10).'</h6>
        <p>'.character_limiter(strip_tags($row->artikel_content,50)).'</p>
        <hr />';
        }

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->artikel_title;
	    $vdata['page_title1'] = 'Artikel';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - renungan
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function renungan($page=0)
	{

        $page = addslashes(trim($page));
        $total_row = PER_PAGE;

	    $this->load->model('Renungan_model');
        $res = $this->Renungan_model->get(array(

                                                        'where' => ' AND display = 1',
                                                        'order' => ' order by created_date desc',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/renungan/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '';
        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'renungan',
					  @rawurlencode("$row->renungan_id"),
					  url_title("$row->renungan_title"),
					  );

        $list .= '<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->renungan_title.'</a></h4>
        <h6 class="text-muted">'.substr($row->created_date,0,10).'</h6>
        <p>'.character_limiter(strip_tags($row->renungan_content,50)).'</p>
        <hr />';
        }

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->renungan_title;
	    $vdata['page_title1'] = 'Renungan';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - kegiatan
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function kegiatan($page=0)
	{

        $page = addslashes(trim($page));
        $total_row = PER_PAGE;

	    $this->load->model('Kegiatan_model');
        $res = $this->Kegiatan_model->get(array(

                                                        'where' => ' AND display = 1',
                                                        'order' => ' order by created_date desc',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/kegiatan/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '';
        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'kegiatan',
					  @rawurlencode("$row->kegiatan_id"),
					  url_title("$row->kegiatan_title"),
					  );

        $list .= '<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->kegiatan_title.'</a></h4>
        <h6 class="text-muted">'.substr($row->created_date,0,10).'</h6>
        <p>'.character_limiter(strip_tags($row->kegiatan_content,50)).'</p>
        <hr />';
        }

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->kegiatan_title;
	    $vdata['page_title1'] = 'Kegiatan';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - kegiatan liturgi
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function kegiatanliturgi($page=0)
	{

        $page = addslashes(trim($page));
        $total_row = PER_PAGE;

	    $this->load->model('Kegiatanliturgi_model');
        $res = $this->Kegiatanliturgi_model->get(array(

                                                        'where' => ' AND display = 1',
                                                        'order' => ' order by created_date desc',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/kegiatanliturgi/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '';
        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'kegiatanliturgi',
					  @rawurlencode("$row->kegiatan_id"),
					  url_title("$row->kegiatan_title"),
					  );

        $list .= '<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->kegiatan_title.'</a></h4>
        <h6 class="text-muted">'.substr($row->created_date,0,10).'</h6>
        <p>'.character_limiter(strip_tags($row->kegiatan_content,50)).'</p>
        <hr />';
        }

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->kegiatan_title;
	    $vdata['page_title1'] = 'Kegiatan';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - laporan_kegiatan
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function laporan_kegiatan($page=0)
	{

        $page = addslashes(trim($page));
        $total_row = PER_PAGE;

	    $this->load->model('Laporan_kegiatan_model');
        $res = $this->Laporan_kegiatan_model->get(array(

                                                        'where' => ' AND display = 1',
                                                        'order' => ' order by created_date desc',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/laporan_kegiatan/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '';
        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'laporan_kegiatan',
					  @rawurlencode("$row->laporan_kegiatan_id"),
					  url_title("$row->laporan_kegiatan_title"),
					  );

        $list .= '<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->laporan_kegiatan_title.'</a></h4>
        <h6 class="text-muted">'.substr($row->created_date,0,10).'</h6>
        <p>'.character_limiter(strip_tags($row->laporan_kegiatan_content,50)).'</p>
        <hr />';
        }

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->laporan_kegiatan_title;
	    $vdata['page_title1'] = 'Laporan_kegiatan';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - pengumuman
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function pengumuman($page=0)
	{

        $page = addslashes(trim($page));
        $total_row = PER_PAGE;

	    $this->load->model('Pengumuman_model');
        $res = $this->Pengumuman_model->get(array(

                                                        'where' => ' AND display = 1',
                                                        'order' => ' order by created_date desc',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/pengumuman/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '';
        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'pengumuman',
					  @rawurlencode("$row->pengumuman_id"),
					  url_title("$row->pengumuman_title"),
					  );

        $list .= '<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->pengumuman_title.'</a></h4>
        <h6 class="text-muted">'.substr($row->created_date,0,10).'</h6>
        <p>'.character_limiter(strip_tags($row->pengumuman_content,50)).'</p>
        <hr />';
        }

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->pengumuman_title;
	    $vdata['page_title1'] = 'Pengumuman';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - pelayanan
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function pelayanan($page=0)
	{

        $page = addslashes(trim($page));
        $total_row = PER_PAGE;

	    $this->load->model('Pelayanan_model');
        $res = $this->Pelayanan_model->get(array(

                                                        'where' => ' AND display = 1',
                                                        'order' => ' order by created_date desc',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/pelayanan/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '';
        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'pelayanan',
					  @rawurlencode("$row->pelayanan_id"),
					  url_title("$row->pelayanan_title"),
					  );

        $list .= '<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->pelayanan_title.'</a></h4>
        <h6 class="text-muted">'.substr($row->created_date,0,10).'</h6>
        <p>'.character_limiter(strip_tags($row->pelayanan_content,50)).'</p>
        <hr />';
        }

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->pelayanan_title;
	    $vdata['page_title1'] = 'Pelayanan';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - dombaku
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function dombaku($page=0)
	{

        $page = addslashes(trim($page));
        //$total_row = PER_PAGE;
        $total_row = 15;

	    $this->load->model('Dombaku_model');
        $res = $this->Dombaku_model->get(array(

                                                        'where' => ' AND publish = 1',
                                                        'order' => ' order by datein desc',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/dombaku/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '<div class="row">';

        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'dombaku',
					  @rawurlencode("$row->id"),
					  url_title("$row->title"),
					  );

		$fpath = FILEPATH_USERFILES."dombaku/".$row->image;

        /*if(file_exists($fpath)){


          $pdf_file   = FILEPATH_USERFILES."dombaku/".$row->image;
          $save_to    = FILEPATH_USERFILES."dombaku/thumb_".$row->id.".jpg";
          if(!file_exists($save_to)){
            $img = new imagick($pdf_file.'[0]');
            $img->setResolution(200,200);
            //reduce the dimensions - scaling will lead to black color in transparent regions
            $img->scaleImage(800,0);
             //set new format
            $img->setImageFormat('jpg');
            $img = $img->flattenImages();
            //save image file
            $img->writeImages($save_to, false);
          }

          //$fl = '<a href="'.base_url().'gui/userfiles/dombaku/'.$row->image.'"><img src="'.SITE_URL.'/gui/images/pdf-icon.png" width="30" /> Download PDF</a>';
          $fl = '<a href="'.base_url().'gui/userfiles/dombaku/'.$row->image.'"><img src="'.SITE_URL.'/gui/userfiles/dombaku/thumb_'.$row->id.'.jpg" width="200" /></a>';
        }   */

        //'<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->title.'</a></h4>
        //<h6 class="text-muted">'.substr($row->datein,0,10).'</h6>
        /*$list .= '<h4 class="text-warning">'.$row->title.'</h4>
        '.$fl.'
        <hr />';
		*/
        $fl = '<a href="'.base_url().'gui/userfiles/dombaku/'.$row->image.'"><img src="'.SITE_URL.'/gui/images/pdf-icon.png" width="30" /> Download PDF</a>';
        $list = $list.'<div class="col-sm-12 col-md-4">
        <h3>'.$row->title.'</h3>
        '.$fl.
        '</div>';
        }

        $list = $list.'</div>';

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->title;
	    $vdata['page_title1'] = 'Bulletin Dwimingguan';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - bacaanmingguan
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function bacaanmingguan($page=0)
	{

        $page = addslashes(trim($page));
        $total_row = PER_PAGE;

	    $this->load->model('Bacaanmingguan_model');
        $res = $this->Bacaanmingguan_model->get(array(

                                                        'where' => ' AND publish = 1',
                                                        'order' => ' order by content_dt',
                                                        'limit' => " LIMIT $page,$total_row",
                                                      ));

        $config['base_url'] = site_url('content/bacaanmingguan/');
        $config['total_rows'] = $res['total'];
        $config['per_page'] = $total_row;
        $vdata['gData'] = $res['data'];

        $this->pagination->initialize($config);

        $vdata['gData_pagination'] = $this->pagination->create_links();

        //-------------------

        $list = '';
        foreach($res['data'] as $row){

        $seq      = array('content',
					  'content_details',
					  'bacaanmingguan',
					  @rawurlencode("$row->id"),
					  url_title("$row->title"),
					  );

		$fpath = FILEPATH_USERFILES."bacaanmingguan/".$row->image;
        $fl = '';
        //if(file_exists($fpath)){
        if($row->image != null){
		    $fl = '<a href="'.base_url().'gui/userfiles/bacaanmingguan/'.$row->image.'"><img src="'.SITE_URL.'/gui/images/downloadfile.png" width="30" /> Download File</a>';
        }

        //'<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->title.'</a></h4>
        //<h6 class="text-muted">'.substr($row->datein,0,10).'</h6>
        $list .= '<h4 class="text-warning"><a href="'.site_url($seq).'">'.$row->title.'</a></h4>
        '.$fl.'
        <hr />';
        }

	    $vdata['list'] = $list;
	    $vdata['page_title'] = $row->title;
	    $vdata['page_title1'] = 'Bacaan Dwimingguan';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - content_details
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function content_details($type,$id)
	{

	    if(strtolower($type)=='artikel')
	    {
            $this->load->model('Artikel_model');
            $res = $this->Artikel_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND display= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->artikel_title;
            $content = $res['data']->artikel_content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }
        elseif(strtolower($type)=='renungan')
	    {
            $this->load->model('Renungan_model');
            $res = $this->Renungan_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND display= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->renungan_title;
            $content = $res['data']->renungan_content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }
        elseif(strtolower($type)=='pengumuman')
	    {
            $this->load->model('Pengumuman_model');
            $res = $this->Pengumuman_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND display= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->pengumuman_title;
            $content = $res['data']->pengumuman_content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }elseif(strtolower($type)=='kegiatan')
	    {
            $this->load->model('Kegiatan_model');
            $res = $this->Kegiatan_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND display= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->kegiatan_title;
            $content = $res['data']->kegiatan_content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }elseif(strtolower($type)=='kegiatanliturgi')
	    {
            $this->load->model('Kegiatanliturgi_model');
            $res = $this->Kegiatanliturgi_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND display= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->kegiatan_title;
            $content = $res['data']->kegiatan_content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }elseif(strtolower($type)=='laporan_kegiatan')
	    {
            $this->load->model('Laporan_kegiatan_model');
            $res = $this->Laporan_kegiatan_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND display= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->laporan_kegiatan_title;
            $content = $res['data']->laporan_kegiatan_content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }elseif(strtolower($type)=='pelayanan')
	    {
            $this->load->model('Pelayanan_model');
            $res = $this->Pelayanan_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND display= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->pelayanan_title;
            $content = $res['data']->pelayanan_content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }elseif(strtolower($type)=='dombaku')
	    {
            $this->load->model('Dombaku_model');
            $res = $this->Dombaku_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND publish= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->dombaku_title;
            $content = $res['data']->dombaku_content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }
        elseif(strtolower($type)=='bacaanmingguan')
	    {
            $this->load->model('Bacaanmingguan_model');
            $res = $this->Bacaanmingguan_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND publish= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->title;
            $content = $res['data']->content;

            if($res['status']==0)
            {
                redirect('home');
            }
        }elseif(strtolower($type)=='main')
	    {
            $this->load->model('Header_news_model');
            $res = $this->Header_news_model->select_by_id(array(
                                                            'id'    => $id,
                                                            'where' => " AND publish= 1",
                                                          ));

            $vdata['gData'] = $res['data'];

            $title = $res['data']->title;
            $content = $res['data']->content;

            $arr_exp = explode('.',$res['data']->image);
            $img = $res['data']->id.'.'.$arr_exp[1];
            $img = PATH_USERFILES.'header_news/'.$img;
            $vdata['img'] = $img;

            if($res['status']==0)
            {
                redirect('home');
            }
        }
        else
        {
            redirect('home');
        }

      $vdata['thumbImg'] = isset($img) ? $img : null;
	    $vdata['title'] = $title;
	    $vdata['content'] = $content;
	    $vdata['type'] = $type;
	    $vdata['page_title'] = $title;
	    $vdata['page_title1'] = $title;
      $this->load->view('content.details.php',$vdata);
	}

	/**
	| @name
	|      -
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function tentangkkis()
	{
	    $this->load->model('Page_model');
        $res = $this->Page_model->select_by_id(array(

                                                        'page_name' => 'Tentang KKIS',
                                                      ));


	    $vdata['list'] = $res['data']->page_v;
	    $vdata['page_title'] = 'Tentang KKIS';
	    $vdata['page_title1'] = 'Tentang KKIS';

        $this->load->view('content.list.php',$vdata);
	}

	/**
	| @name
	|      - contact us
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function kontak($flg='')
	{
	    $vdata['flag']=$flg;
        $this->load->helper('captcha');
        $vals = array(
            'img_path' => FILEPATH_CAPTCHA,
            'img_url' => URL_CAPTCHA,
            'font_path' => FONTPATH_CAPTCHA,
            'img_width' => 300,
            'img_height' => 60
            );

        $cap = create_captcha($vals);

        $ip_add = $this->input->ip_address();
        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $ip_add,
            'word' => $cap['word']
            );

        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);

        $vdata['img_src'] = $cap['image'];

	    $this->load->model('Page_model');
        $res = $this->Page_model->select_by_id(array(

                                                        'page_name' => 'Kontak',
                                                      ));


	    $vdata['list'] = isset($res['data']->page_v) ? $res['data']->page_v : null;
	    $vdata['page_title'] = 'Kontak';
	    $vdata['page_title1'] = 'Kontak';
	    $vdata['keyadd'] = base64_encode($ip_add);

        $this->load->view('contact.us.php',$vdata);
	}

    function kontak_process()
    {


        //$this->load->helper('email');

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['mobile'];
        $message = $_POST['message'];
        $type = $_POST['type'];
        $keyadd = base64_decode($_POST['keyadd']);

        if($type=="romo")
            $recipient = $this->config->item('EMAIL_KONTAK_ROMO');
        else
            $recipient = $this->config->item('EMAIL_KONTAK');
        var_dump($recipient);

        // First, delete old captchas
$expiration = time()-7200; // Two hour limit
$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

// Then see if a captcha exists:
$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
$binds = array($_POST['captcha'], $keyadd, $expiration);

$query = $this->db->query($sql, $binds);
$row = $query->row();

if ($row->count == 0)
{
    $stat= "errcaptcha";
}else{

        if(trim($message)!='')
        {

            //$recipient ='cuhaowen@yahoo.com';
            $subject = 'Enquiry from KKIS Website';

            $message = 'Someone has been sent an enquiry.

            Name: '.$name.'
            Email: '.$email.'
            Phone: '.$phone.'
            Message: '.$message.'

            Regards,

            Admin KKIS.org
            ';


            $this->load->library('email');

            $this->email->from($this->config->item('DEFAULT_FROM_EMAIL'), 'Admin KKIS.org');
            $this->email->to($recipient);

            $this->email->subject($subject);
            $this->email->message($message);

            $this->email->send();
            $stat='ok';
        }
        else
        {
            $stat='emptymsg';
        }
        //echo $this->email->print_debugger();

       }

        redirect('content/kontak/'.$stat);

    }


  function contact_us()
	{
        $this->load->helper('captcha');
        $vals = array(
            'img_path' => FILEPATH_CAPTCHA,
            'img_url' => URL_CAPTCHA,
            'font_path' => FONTPATH_CAPTCHA,
            'img_width' => 200,
            'img_height' => 60
            );

        $cap = create_captcha($vals);

        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
            );

        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);

        $vdata['img_src'] = $cap['image'];

        $this->load->view('contact.us.php',$vdata);

        /* after submit
        // First, delete old captchas
        $expiration = time()-7200; // Two hour limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0)
        {
            echo "You must submit the word that appears in the image";
        }
        */
	}

	/**
	| @name
	|      -
	|
	| @params
	|      -
	|
	| @return
	|      -
	|
	| @description
	|      - default controller
	|
	**/
	function strukturorganisasi()
	{
	/*    	$this->load->model('Page_model');
        	$res = $this->Page_model->select_by_id(array(

                        'page_name' => 'Struktur Organisasi KKIS',
                      ));
        */

		//$vdata['list'] = $res['data']->page_v;
		$vdata['page_title'] = 'Struktur Organisasi KKIS';
		$vdata['page_title1'] = 'Struktur Organisasi KKIS';
        # $imgdata = '<p align="center"><img src="'.SITE_URL.'/gui/images/pengurus20162018.jpg" class="img-responsive"></p>';
		$imgdata = '<p align="center"></p>';
		$vdata['list'] = $imgdata; //"Under construction";

        	$this->load->view('content.list.php',$vdata);
	}

   	function strukturorganisasi2()
	{
	/*    	$this->load->model('Page_model');
        	$res = $this->Page_model->select_by_id(array(

                        'page_name' => 'Struktur Organisasi KKIS',
                      ));
        */

		//$vdata['list'] = $res['data']->page_v;
		$vdata['page_title'] = 'Struktur Organisasi KKIS';
		$vdata['page_title1'] = 'Struktur Organisasi KKIS';
		$vdata['list'] = "Under construction";

        	$this->load->view('strukturorganisasi.php',$vdata);
	}

	function visimisikkis()
	{
		$vdata['page_title'] = 'Visi & Misi KKIS';
		$vdata['page_title1'] = 'Visi & Misi KKIS';
        $vdata['list'] = '
            <h3>Visi KKIS</h3>
            <p>Menjadi wadah bagi semua umat katolik berbahasa Indonesia di Singapura dan membantu serta melayani umat memenuhi kebutuhan rohani dan sosial mereka di Singapura.</p>
            <h3>Misi KKIS</h3>
            <ol>
                <li>Menjadi wadah, bagi umat Katolik berbahasa Indonesa di Singapura, yang semakin mendekatkan umatnya kepada Tuhan.</li>
                <li>Pengurus mengadakan kegiatan-kegiatan rutin* / tidak rutin yang bersifat rohani (meningkatkan iman) dan bersifat sosial dengan patuh kepada ketentuan Keuskupan Agung Singapura dan juga kepada peraturan-peraturan Pemerintah negara Singapura.</li>
                <li>Membina relasi dan keakraban (juga melalui orang tua mereka), membuat mereka merasa nyaman; yang direalisasikan dengan kegiatan seperti olahraga, piknik, seni, dsb.</li>
                <li>Lebih memperkenalkan keberadaan KKIS dan pelayanan Sakramen-sakramen oleh KKIS kepada kepada orang-orang di Indonesia melalui paroki-paroki.</li>
                <li>Mendokumentasikan prosedur-prosedur yang sering kali dipakai, misalnya prosedur mengundang pembicara, prosedur menanggapi permintaan bantuan dana, prosedur menjawab kelompok paduan suara yang mau mengisi koor di misa KKIS.</li>
                <li>Memulai dan membina hubungan dengan mahasiswa katolik Indonesia; mengadakan acara selamat datang bagi pelajar di saat mereka baru datang untuk memulai tahun ajaran.</li>
                <li>Memulai dan mengembangkan aktivitas kelompok Migran dan kelompok Pelaut.</li>
                <li>Mengadakan retret bagi Pengurus KKIS, setahun sekali.</li>
                <li>Saling mendukung, memelihara dan membina bidang-bidang dan unit-unit yang ada.</li>
                <li>Membina hubungan yang baik dengan komunitas-komunitas katolik lainnya.</li>
            </ol>
            ';
        $this->load->view('content.list.php',$vdata);
	}



}
