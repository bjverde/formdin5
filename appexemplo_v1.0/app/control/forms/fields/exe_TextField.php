<?php

use Adianti\Registry\TSession;

class exe_TextField extends TPage
{
    protected $form; // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    // trait com onReload, onSearch, onDelete...
    use Adianti\Base\AdiantiStandardListTrait;

    function __construct()
    {
        parent::__construct();



        $frm = new TFormDin('Exemplo do Campo Texto');

        $frm->addTextField('TEXT01','Texto tam 10', 10);
        $frm->addTextField('TEXT02','Texto obrigatorio', 10,true);
        $frm->addTextField('TEXT03', 'Com valor inicial', 50, null,null,'inicial');
        $frm->addTextField('TEXT04', 'Place Holder', 50, null,null,null,null,null,'Place Holder');
        $frm->addTextField('TEXT05', 'Leitura 01', 50, null,null,'inicial')->setReadOnly(true);        
        $x = $frm->addTextField('TEXT06', 'Leitura 02', 50, null,null,'inicial');
        $x->setReadOnly(true);

        $this->form = $frm->show();


        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data'));

        // add form actions
        $this->form->addAction('Send', new TAction(array($this, 'onSend')), 'far:check-circle green');
        $this->form->addActionLink('Clear',  new TAction([$this, 'clear']), 'fa:eraser red');

        // creates the page structure using a table
        $formDinBreadCrumb = new TFormDinBreadCrumb(__CLASS__);
        $vbox = $formDinBreadCrumb->getAdiantiObj();
        $vbox->add($this->form);
        
        // add the table inside the page
        parent::add($vbox);
    }

    /**
     * Clear filters
     */
    function clear()
    {
        $this->clearFilters();
        $this->onReload();
    }

    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);    
        FormDinHelper::debug($param,'$param');
        FormDinHelper::debug($data,'$data');
        FormDinHelper::debug($_REQUEST,'$_REQUEST');
    }
}