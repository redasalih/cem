        </content>
      <?php
        // die('i am here');
      global $gummWpHelper, $GummTemplateBuilder, $gummLayoutHelper, $gummHtmlHelper;
      ?>
      <?php $gummLayoutHelper->contentTagClose(); ?> <!-- .main-content end -->
      <?php $gummLayoutHelper->getSidebarForPage('right'); ?>

      

      <span class="clear"></span>

        <?php
        if (!is_page(107)) // ===>   la page nos partenaires
        {
          // echo '<div class="partenaires  bluebox-heading"><h3>Partenaires</h3><a class="catShowAll" href="http://caravaneemploi.com/partenaires/nos-partenaires">Tous les partenaires +</a>';
          // kw_sc_logo_carousel('partenaires');
          // echo '</div>';
          echo  do_shortcode('[xyz-ihs snippet="Footer-Partenaire-Officiel"]');


          // echo '<div class="partenaireMedia  bluebox-heading"><h3>Les partenaires Médias</h3><span class="clear"></span>';
            // echo '<div class="partner col-md-3"><h2>TV</h2>';
            //   kw_sc_logo_carousel('tv');
            // echo '</div>';
            // echo '<div class="partner col-md-9"><h2>Radio</h2>';
            //   kw_sc_logo_carousel('radio');
            // echo '</div>';
            // echo'<span class="clear"></span>';
            echo  do_shortcode('[xyz-ihs snippet="Footer-Partenaire-Media"]');
          // echo '</div>';

          // echo '<div class="partenaireMedia  bluebox-heading">';
          //   echo '<div class="partner col-md-12"><h2>Presse et WEB</h2>';
          //     kw_sc_logo_carousel('presse-et-web');
          //   echo '</div>';
          // echo '</div>';
        }
        if (is_page(1745)) // ===>   la page nos partenaires
        {
            echo  do_shortcode('[xyz-ihs snippet="Footer-Partenaire-Officiel"]');

        }
        ?>

    </div> <!-- .row end -->
    <span class="clear"></span>
  </div>
  
  <?php
  $gummSidebarHtml1 = $gummHtmlHelper->getSidebarHtml('gumm-footer-sidebar-1');
  $gummSidebarHtml2 = $gummHtmlHelper->getSidebarHtml('gumm-footer-sidebar-2');
  $gummSidebarHtml3 = $gummHtmlHelper->getSidebarHtml('gumm-footer-sidebar-3');
  $gummSidebarHtml4 = $gummHtmlHelper->getSidebarHtml('gumm-footer-sidebar-4');

  $gummNumColumns = (int) $gummWpHelper->getOption('footer_columns');
  ?>
  
  <?php if ($gummNumColumns > 0): ?>
</div>
  <footer>
    <div class="content_footer">
      <div class="row">
        <?php
            for ($i=1; $i<=$gummNumColumns; $i++) {
                $varName = 'gummSidebarHtml' . $i;
                echo '<div class="' . $gummLayoutHelper->getLayoutColumnsNumberClassName($gummNumColumns) . '">' . $$varName . '</div>';
            }
        ?>
      </div>
      <?php //$gummHtmlHelper->displayMenu(array('class' => 'footer-nav')); ?>
      <?php wp_nav_menu( array( 'theme_location' => 'footer_nav_menu' ) ); ?>
    </div>
  </footer>
  <?php if ($gummCopyrightsText = $gummWpHelper->getOption('footer.bottom_text')): ?>
  <div class="copyrights-content">
    <div class="content_footer">
      <font color="white">© <?= date('Y') ?> AmalJOB</font>
      <ul>
        <li><a href="http://www.amaljob.com/" target="_blank" class="echlfooter" title="Offres d’emploi au Maroc">Amaljob.com</a></li>
        <li><a href="http://www.sourceo.net/" target="_blank" class="echlfooter" title="Sourceo est un logiciel de e-recrutement en mode SaaS">Sourceo.net</a></li>
        <li><a href="http://www.caravaneemploi.com/" target="_blank" class="echlfooter" title="Caravane Emploi et Métiers">Caravaneemploi.com</a></li>
      </ul>
      <span class="clear" style="clear:both;"></span>
    </div>
    <?php //echo $gummCopyrightsText; ?>
  </div>
  <?php endif; ?>
  <?php endif; ?>
<?php if ($gummFooterLogoUrl = $gummWpHelper->getOption('footer.logo')): ?>
<div class="footer-logo">
    <?php echo $gummHtmlHelper->displayLogo(array('location' => 'footer', 'homeLink' => false)); ?>
</div>
<?php endif; ?>
</div>
<?php View::renderElement('footer/audio-player'); ?>

<span id="bb-page-loader-icon" class="bb-css3-preloader bb-icon-loading-content">
    <span></span>
</span>



    <!-- Go to www.addthis.com/dashboard to generate a new set of sharing buttons 
    ===  Bouton partage Mobile
      =============================================================================-->
    <div class="socialMobile" style="display:none;">
      <?php
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      ?>
      <a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?=$actual_link?>" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/></a>

      <a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?=$actual_link?>" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/></a>

      <a href="https://api.addthis.com/oexchange/0.8/forward/linkedin/offer?url=<?=$actual_link?>" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/linkedin.png" border="0" alt="LinkedIn"/></a>

      <a href="https://api.addthis.com/oexchange/0.8/forward/google_plusone_share/offer?url=<?=$actual_link?>" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/google_plusone_share.png" border="0" alt="Google+"/></a>

      <a href="https://api.addthis.com/oexchange/0.8/forward/viadeo/offer?url=<?=$actual_link?>" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/viadeo.png" border="0" alt="Viadeo"/></a>
    </div>




<?php // View::renderElement('front-end-preview-panel'); ?>

<?php echo $gummWpHelper->getOption('google_analytics'); ?>

<?php wp_footer(); ?>


<!-- chosen pour les formulaires  -->
<?php
$url = get_stylesheet_directory_uri();
?>
  <link rel="stylesheet" id="bootstrap-css" href="<?= $url ?>/app/assets/js/FlipClock/compiled/flipclock.css" type="text/css" media="all">
  <script type="text/javascript" src="<?= $url ?>/app/assets/js/FlipClock/compiled/flipclock.min.js"></script>
  <!--<script type="text/javascript" src="<?= $url ?>/app/assets/js/jquery.countdown.js"></script>-->
  <script type="text/javascript" src="<?= $url ?>/app/assets/js/main.js"></script>
<?php
if (is_page(110) or is_page(89) or is_page(78) or is_page(112) or is_page(1470)  or is_page(1549)  or is_page(1542) or is_page(1867)  )
{
  $url = get_stylesheet_directory_uri();
?>
  <!-- =====   Slid Quiz ====== -->
  <script src="<?= $url ?>/app/assets/js/jquery.bootstrap.wizard.js"></script>
  <script src="<?= $url ?>/app/assets/js/jquery.bootstrap.wizard.js"></script>

  <!-- ======   style form   ====== -->
  <!--<link rel="stylesheet" id="bootstrap-css" href="<?= $url ?>/app/assets/js/chosen/chosen.css" type="text/css" media="all">
  <script type="text/javascript" src="<?= $url ?>/app/assets/js/chosen/chosen.jquery.js"></script>-->
  <script type="text/javascript" src="<?= $url ?>/app/assets/js/nicescroll/jquery.nicescroll.js"></script>

  <script type="text/javascript" src="<?= $url ?>/app/assets/js/chosen/master.js"></script>
<?php
}
?>

    

<style type="text/css">



.content-wrap .main-container header nav ul li>ul li.current_page_item>a {
  background: none !important;
  color: #e74c3c !important;
  box-shadow: none !important;
}
.content-wrap .main-container header nav ul li>ul li a:hover{
  box-shadow: none !important;
}

</style>



</body>
</html>
