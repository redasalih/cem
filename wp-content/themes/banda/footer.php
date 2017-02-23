        </content>
      <?php
      global $gummWpHelper, $GummTemplateBuilder, $gummLayoutHelper, $gummHtmlHelper;
      ?>
      <?php $gummLayoutHelper->contentTagClose(); ?> <!-- .main-content end -->
      <?php $gummLayoutHelper->getSidebarForPage('right'); ?>

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
  <footer>
      <div class="row">
        <?php
            for ($i=1; $i<=$gummNumColumns; $i++) {
                $varName = 'gummSidebarHtml' . $i;
                echo '<div class="' . $gummLayoutHelper->getLayoutColumnsNumberClassName($gummNumColumns) . '">' . $$varName . '</div>';
            }
        ?>
      </div>
  </footer>
  <?php endif; ?>
  <?php if ($gummCopyrightsText = $gummWpHelper->getOption('footer.bottom_text')): ?>
  <div class="copyrights-content">
     <?php echo $gummCopyrightsText; ?>
  </div>
  <?php endif; ?>
</div>
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

<?php // View::renderElement('front-end-preview-panel'); ?>

<?php echo $gummWpHelper->getOption('google_analytics'); ?>

<?php wp_footer(); ?>
</body>
</html>
