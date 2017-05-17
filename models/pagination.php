<?php

class Pagination extends  CI_Model{

    const  BASEURL='http://mylocal.dev/MyPHP_files/school/index.php/';

    protected $total_pages=0;
    protected $baseurl='';
    protected $per_page=0;
    protected $active_page=1;
    protected $querystring='';

    public function __construct($controller_action)
    {
        $this->baseurl=self::BASEURL;
        $this->querystring=$this->baseurl.$contoller_action."?page=";

    }

    public function create(){

        echo '<div class="row">
    <nav aria-label="...">
        <ul class="pager">
            <li><a  href="<?php  echo "$this->getQueryString()1"; ?>"><i class="glyphicon glyphicon-step-backward"></i></a></li>

            <li><a  href="<?php  ($this->active_page >3) ? $page=$this->active_page-1 :$page=1; echo PATH."/homeController/getTeachersList?page={$page}"; ?>"><i class="glyphicon glyphicon-backward"></i></a></li>
                         <?php   if($this->active_page-1<=1)
                        {$j=1;$this->active_page = 1;
                        } else {
                                $j = $this->active_page - 1;
                            } for ($i=$j; $i<$j+$this->per_page;$i++) {?>
            <li class="<?php echo($i<=$this->total_pages)?\'active\':\'disabled\'; ?>"><a href="<?php   echo ($i-1<$this->total_pages)? $this->getQueryString(){$i} :$this->getQueryString(){$this->total_pages}; ?>"><?php echo $i; ?><span class="sr-only">(current)</span></a></li>
                        <?php  }?>

             <li><a href="<?php ( $this->active_page< $this->total_pages) ? $page=$this->active_page+1 :$page=$this->total_pages; echo $this->getQueryString(){$page}; ?>"><i class="glyphicon glyphicon-forward"></i></a></li>
             <li><a href="<?php  echo $this->getQueryString().$total_pages; ?>"><i class="glyphicon glyphicon-step-forward"></i></a></li>
        </ul>
    </nav>
</div>';

    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->total_pages;
    }

    /**
     * @param int $total_pages
     */
    public function setTotalPages($total_pages)
    {
        $this->total_pages = $total_pages;
    }

    /**
     * @return string
     */
    public function getBaseurl()
    {
        return $this->baseurl;
    }

    /**
     * @param string $baseurl
     */
    public function setBaseurl($baseurl)
    {
        $this->baseurl = $baseurl;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @param int $per_page
     */
    public function setPerPage($per_page)
    {
        $this->per_page = $per_page;
    }

    /**
     * @return int
     */
    public function getActivePage()
    {
        return $this->active_page;
    }

    /**
     * @param int $active_page
     */
    public function setActivePage($active_page)
    {
        $this->active_page = $active_page;
    }

    /**
     * @return string
     */
    public function getQuerystring()
    {
        return $this->querystring;
    }

    /**
     * @param string $querystring
     */
    public function setQuerystring($controller_action)
    {
        $this->querystring =$this->baseurl.$controller_action."?page=";
    }


}