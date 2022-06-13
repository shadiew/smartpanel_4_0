<style>
  .page-title h1{
    margin-bottom: 5px; }
    .page-title .border-line {
      height: 5px;
      width: 175px;
      background: #eca28d;
      background: -webkit-linear-gradient(45deg, #eca28d, #f98c6b) !important;
      background: -moz- oldlinear-gradient(45deg, #eca28d, #f98c6b) !important;
      background: -o-linear-gradient(45deg, #eca28d, #f98c6b) !important;
      background: linear-gradient(45deg, #eca28d, #f98c6b) !important;
      position: relative;
      border-radius: 30px; }
    .page-title .border-line::before {
      content: '';
      position: absolute;
      left: 0;
      top: -2.7px;
      height: 10px;
      width: 10px;
      border-radius: 50%;
      background: #fa6d7e;
      -webkit-animation-duration: 4s;
      animation-duration: 4s;
      -webkit-animation-timing-function: linear;
      animation-timing-function: linear;
      -webkit-animation-iteration-count: infinite;
      animation-iteration-count: infinite;
      -webkit-animation-name: moveIcon;
      animation-name: moveIcon; }

  @-webkit-keyframes moveIcon {
    from {
      -webkit-transform: translateX(0);
    }
    to { 
      -webkit-transform: translateX(175px);
    }
  }
</style>

<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="page-title m-b-30">
      <h1>
        <?php echo lang('Cookie_Policy'); ?>
      </h1>
      <div class="border-line"></div>
    </div>
    <div class="content">
      <?php echo get_option("cookies_policy_page", ""); ?>
    </div>
  </div>  
</div>

