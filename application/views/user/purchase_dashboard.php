<div id="page_content">
   <div id="page_heading" data-uk-sticky="{ top: 40, media: 960 }">        
        <h1>Konark Purchase Department</h1>
    </div>

  <div id="page_content_inner">
    <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
      <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,3,9,6,5,9,7</span></div>
            <span class="uk-text-muted uk-text-small">Total Client</span>
            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?=$clientCount?></noscript></span></h2>
          </div>
        </div>
      </div>
      <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
            <span class="uk-text-muted uk-text-small">Total Design</span>
            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?=$callCount?></noscript></span></h2>
          </div>
        </div>
      </div>
      <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
            <span class="uk-text-muted uk-text-small">Total Purchase</span>
            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?=$pendingCall?></noscript></span></h2>
          </div>
        </div>
      </div>
      <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
            <span class="uk-text-muted uk-text-small">Total Production</span>
            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?=$pendingCall?></noscript></span></h2>
          </div>
        </div>
      </div>
      <!-- <div>
        <div class="md-card">
          <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
            <span class="uk-text-muted uk-text-small">Total Purchase</span>
            <h2 class="uk-margin-remove"><span class="countUpMe"><noscript><?=$reportCont?></noscript></span></h2>
          </div>
        </div>
      </div> -->
    </div>
    <br>  
  <?php if($role != ROLE_EMPLOYEE) { ?>
 <div class="uk-width-large-1-2 uk-width-small-1-1">
        
          
            <?php $success = $this->session->flashdata('Success');
            if(isset($success)) { ?>
                <div class="uk-alert uk-alert-success" data-uk-alert>
                    <a href="#" class="uk-grid uk-alert-close uk-close"></a>
                   <a href="<?php echo base_url(); ?>message"> <?php echo $this->session->flashdata('Success'); ?> </a>                   
                </div>
             
        <?php } ?>
        </div>

      
    <?php } ?>
   

    <hr>
    
  </div>
</div>

<?php

// $favorites = array( 
//                     "Dave Punk" => array( 
//                                         "mob" => "5689741523",
//                                         "email" => "davepunk@gmail.com",
//                                     ), 
//                     "Dave Punk" => array( 
//                                         "mob" => "2584369721", 
//                                         "email" => "montysmith@gmail.com", 
//                                     ), 
//                     "John Flinch" => array( 
//                                         "mob" => "9875147536", 
//                                         "email" => "johnflinch@gmail.com", 
//                                     ) 
//                 ); 
?>
