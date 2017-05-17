<?php

class Pagination extends HomeController{

    private $active_page;
    private $total_pages;
    private $baseURL;
    private $rows_per_page;
    private $search;

/*    public function __construct()
    {
        parent::__construct();
    }
*/
    public function __construct($active_page,$total_pages,$baseURL=null,$rows_per_page=null,$search=null)
    {
        parent::__construct();
        $this->setActivePage($active_page);
        $this->setTotalPages($total_pages);
        $this->setRowsPerPage($baseURL);
        $this->setSearch($search);
        $this->setBaseURL($baseURL);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivePage()
    {
        return $this->active_page;
    }

    /**
     * @param mixed $active_page
     */
    public function setActivePage($active_page)
    {
        $this->active_page = $active_page;
    }

    /**
     * @return mixed
     */
    public function getTotalPages()
    {
        return $this->total_pages;
    }

    /**
     * @param mixed $total_pages
     */
    public function setTotalPages($total_pages)
    {
        $this->total_pages = $total_pages;
    }

    /**
     * @return mixed
     */
    public function getBaseURL()
    {
        return $this->baseURL;
    }

    /**
     * @param mixed $baseURL
     */
    public function setBaseURL($baseURL)
    {
        $this->baseURL = $baseURL;
    }

    /**
     * @return mixed
     */
    public function getRowsPerPage()
    {
        return $this->rows_per_page;
    }

    /**
     * @param mixed $rows_per_page
     */
    public function setRowsPerPage($rows_per_page)
    {
        $this->rows_per_page = $rows_per_page;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param mixed $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }
    public function create(){

        $data['active_page']=$this->getActivePage();
        $data['total_pages']=$this->getTotalPages();
        $data['currentURL']=$this->getBaseURL();
        $data['serach']=$this->getSearch();
        $data['rows_per_page']=$this->getRowsPerPage();
       return $this->load->view('PaginationView',$data);
    }

}