<?php

namespace Application\Entity;

/**
 * Pays
 */
class Pays
{
    /**
     * @var string
     */
    private $alpha2 = '';

    /**
     * @var string
     */
    private $alpha3 = '';

    /**
     * @var string
     */
    private $ar = '';

    /**
     * @var string
     */
    private $bg = '';

    /**
     * @var string
     */
    private $cs = '';

    /**
     * @var string
     */
    private $da = '';

    /**
     * @var string
     */
    private $de = '';

    /**
     * @var string
     */
    private $el = '';

    /**
     * @var string
     */
    private $en = '';

    /**
     * @var string
     */
    private $eo = '';

    /**
     * @var string
     */
    private $es = '';

    /**
     * @var string
     */
    private $et = '';

    /**
     * @var string
     */
    private $eu = '';

    /**
     * @var string
     */
    private $fi = '';

    /**
     * @var string
     */
    private $fr = '';

    /**
     * @var string
     */
    private $hu = '';

    /**
     * @var string
     */
    private $it = '';

    /**
     * @var string
     */
    private $ja = '';

    /**
     * @var string
     */
    private $ko = '';

    /**
     * @var string
     */
    private $lt = '';

    /**
     * @var string
     */
    private $nl = '';

    /**
     * @var string
     */
    private $no = '';

    /**
     * @var string
     */
    private $pl = '';

    /**
     * @var string
     */
    private $pt = '';

    /**
     * @var string
     */
    private $ro = '';

    /**
     * @var string
     */
    private $ru = '';

    /**
     * @var string
     */
    private $sk = '';

    /**
     * @var string
     */
    private $sv = '';

    /**
     * @var string
     */
    private $th = '';

    /**
     * @var string
     */
    private $uk = '';

    /**
     * @var string
     */
    private $zh = '';

    /**
     * @var string
     */
    private $zhTw = '';

    /**
     * @var int
     */
    private $id;


    /**
     * Set alpha2.
     *
     * @param string $alpha2
     *
     * @return Pays
     */
    private function setAlpha2($alpha2)
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    /**
     * Get alpha2.
     *
     * @return string
     */
    public function getAlpha2()
    {
        return $this->alpha2;
    }

    /**
     * Set alpha3.
     *
     * @param string $alpha3
     *
     * @return Pays
     */
    private function setAlpha3($alpha3)
    {
        $this->alpha3 = $alpha3;

        return $this;
    }

    /**
     * Get alpha3.
     *
     * @return string
     */
    public function getAlpha3()
    {
        return $this->alpha3;
    }

    /**
     * Set ar.
     *
     * @param string $ar
     *
     * @return Pays
     */
    private function setAr($ar)
    {
        $this->ar = $ar;

        return $this;
    }

    /**
     * Get ar.
     *
     * @return string
     */
    public function getAr()
    {
        return $this->ar;
    }

    /**
     * Set bg.
     *
     * @param string $bg
     *
     * @return Pays
     */
    private function setBg($bg)
    {
        $this->bg = $bg;

        return $this;
    }

    /**
     * Get bg.
     *
     * @return string
     */
    public function getBg()
    {
        return $this->bg;
    }

    /**
     * Set cs.
     *
     * @param string $cs
     *
     * @return Pays
     */
    private function setCs($cs)
    {
        $this->cs = $cs;

        return $this;
    }

    /**
     * Get cs.
     *
     * @return string
     */
    public function getCs()
    {
        return $this->cs;
    }

    /**
     * Set da.
     *
     * @param string $da
     *
     * @return Pays
     */
    private function setDa($da)
    {
        $this->da = $da;

        return $this;
    }

    /**
     * Get da.
     *
     * @return string
     */
    public function getDa()
    {
        return $this->da;
    }

    /**
     * Set de.
     *
     * @param string $de
     *
     * @return Pays
     */
    private function setDe($de)
    {
        $this->de = $de;

        return $this;
    }

    /**
     * Get de.
     *
     * @return string
     */
    public function getDe()
    {
        return $this->de;
    }

    /**
     * Set el.
     *
     * @param string $el
     *
     * @return Pays
     */
    private function setEl($el)
    {
        $this->el = $el;

        return $this;
    }

    /**
     * Get el.
     *
     * @return string
     */
    public function getEl()
    {
        return $this->el;
    }

    /**
     * Set en.
     *
     * @param string $en
     *
     * @return Pays
     */
    private function setEn($en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en.
     *
     * @return string
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Set eo.
     *
     * @param string $eo
     *
     * @return Pays
     */
    private function setEo($eo)
    {
        $this->eo = $eo;

        return $this;
    }

    /**
     * Get eo.
     *
     * @return string
     */
    public function getEo()
    {
        return $this->eo;
    }

    /**
     * Set es.
     *
     * @param string $es
     *
     * @return Pays
     */
    private function setEs($es)
    {
        $this->es = $es;

        return $this;
    }

    /**
     * Get es.
     *
     * @return string
     */
    public function getEs()
    {
        return $this->es;
    }

    /**
     * Set et.
     *
     * @param string $et
     *
     * @return Pays
     */
    private function setEt($et)
    {
        $this->et = $et;

        return $this;
    }

    /**
     * Get et.
     *
     * @return string
     */
    public function getEt()
    {
        return $this->et;
    }

    /**
     * Set eu.
     *
     * @param string $eu
     *
     * @return Pays
     */
    private function setEu($eu)
    {
        $this->eu = $eu;

        return $this;
    }

    /**
     * Get eu.
     *
     * @return string
     */
    public function getEu()
    {
        return $this->eu;
    }

    /**
     * Set fi.
     *
     * @param string $fi
     *
     * @return Pays
     */
    private function setFi($fi)
    {
        $this->fi = $fi;

        return $this;
    }

    /**
     * Get fi.
     *
     * @return string
     */
    public function getFi()
    {
        return $this->fi;
    }

    /**
     * Set fr.
     *
     * @param string $fr
     *
     * @return Pays
     */
    private function setFr($fr)
    {
        $this->fr = $fr;

        return $this;
    }

    /**
     * Get fr.
     *
     * @return string
     */
    public function getFr()
    {
        return $this->fr;
    }

    /**
     * Set hu.
     *
     * @param string $hu
     *
     * @return Pays
     */
    private function setHu($hu)
    {
        $this->hu = $hu;

        return $this;
    }

    /**
     * Get hu.
     *
     * @return string
     */
    public function getHu()
    {
        return $this->hu;
    }

    /**
     * Set it.
     *
     * @param string $it
     *
     * @return Pays
     */
    private function setIt($it)
    {
        $this->it = $it;

        return $this;
    }

    /**
     * Get it.
     *
     * @return string
     */
    public function getIt()
    {
        return $this->it;
    }

    /**
     * Set ja.
     *
     * @param string $ja
     *
     * @return Pays
     */
    private function setJa($ja)
    {
        $this->ja = $ja;

        return $this;
    }

    /**
     * Get ja.
     *
     * @return string
     */
    public function getJa()
    {
        return $this->ja;
    }

    /**
     * Set ko.
     *
     * @param string $ko
     *
     * @return Pays
     */
    private function setKo($ko)
    {
        $this->ko = $ko;

        return $this;
    }

    /**
     * Get ko.
     *
     * @return string
     */
    public function getKo()
    {
        return $this->ko;
    }

    /**
     * Set lt.
     *
     * @param string $lt
     *
     * @return Pays
     */
    private function setLt($lt)
    {
        $this->lt = $lt;

        return $this;
    }

    /**
     * Get lt.
     *
     * @return string
     */
    public function getLt()
    {
        return $this->lt;
    }

    /**
     * Set nl.
     *
     * @param string $nl
     *
     * @return Pays
     */
    private function setNl($nl)
    {
        $this->nl = $nl;

        return $this;
    }

    /**
     * Get nl.
     *
     * @return string
     */
    public function getNl()
    {
        return $this->nl;
    }

    /**
     * Set no.
     *
     * @param string $no
     *
     * @return Pays
     */
    private function setNo($no)
    {
        $this->no = $no;

        return $this;
    }

    /**
     * Get no.
     *
     * @return string
     */
    public function getNo()
    {
        return $this->no;
    }

    /**
     * Set pl.
     *
     * @param string $pl
     *
     * @return Pays
     */
    private function setPl($pl)
    {
        $this->pl = $pl;

        return $this;
    }

    /**
     * Get pl.
     *
     * @return string
     */
    public function getPl()
    {
        return $this->pl;
    }

    /**
     * Set pt.
     *
     * @param string $pt
     *
     * @return Pays
     */
    private function setPt($pt)
    {
        $this->pt = $pt;

        return $this;
    }

    /**
     * Get pt.
     *
     * @return string
     */
    public function getPt()
    {
        return $this->pt;
    }

    /**
     * Set ro.
     *
     * @param string $ro
     *
     * @return Pays
     */
    private function setRo($ro)
    {
        $this->ro = $ro;

        return $this;
    }

    /**
     * Get ro.
     *
     * @return string
     */
    public function getRo()
    {
        return $this->ro;
    }

    /**
     * Set ru.
     *
     * @param string $ru
     *
     * @return Pays
     */
    private function setRu($ru)
    {
        $this->ru = $ru;

        return $this;
    }

    /**
     * Get ru.
     *
     * @return string
     */
    public function getRu()
    {
        return $this->ru;
    }

    /**
     * Set sk.
     *
     * @param string $sk
     *
     * @return Pays
     */
    private function setSk($sk)
    {
        $this->sk = $sk;

        return $this;
    }

    /**
     * Get sk.
     *
     * @return string
     */
    public function getSk()
    {
        return $this->sk;
    }

    /**
     * Set sv.
     *
     * @param string $sv
     *
     * @return Pays
     */
    private function setSv($sv)
    {
        $this->sv = $sv;

        return $this;
    }

    /**
     * Get sv.
     *
     * @return string
     */
    public function getSv()
    {
        return $this->sv;
    }

    /**
     * Set th.
     *
     * @param string $th
     *
     * @return Pays
     */
    private function setTh($th)
    {
        $this->th = $th;

        return $this;
    }

    /**
     * Get th.
     *
     * @return string
     */
    public function getTh()
    {
        return $this->th;
    }

    /**
     * Set uk.
     *
     * @param string $uk
     *
     * @return Pays
     */
    private function setUk($uk)
    {
        $this->uk = $uk;

        return $this;
    }

    /**
     * Get uk.
     *
     * @return string
     */
    public function getUk()
    {
        return $this->uk;
    }

    /**
     * Set zh.
     *
     * @param string $zh
     *
     * @return Pays
     */
    private function setZh($zh)
    {
        $this->zh = $zh;

        return $this;
    }

    /**
     * Get zh.
     *
     * @return string
     */
    public function getZh()
    {
        return $this->zh;
    }

    /**
     * Set zhTw.
     *
     * @param string $zhTw
     *
     * @return Pays
     */
    private function setZhTw($zhTw)
    {
        $this->zhTw = $zhTw;

        return $this;
    }

    /**
     * Get zhTw.
     *
     * @return string
     */
    public function getZhTw()
    {
        return $this->zhTw;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
