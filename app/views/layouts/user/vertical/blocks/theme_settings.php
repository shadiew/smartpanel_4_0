<div class="modal fade" id="customize" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-right">
        <div class="modal-dialog theme-customizer" role="document">
            <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header bg-pantone">
                <h4 class="modal-title"><i class="icon-fa fa fa-cogs"></i> <?php echo lang('Theme_Customizer'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
                </div>
                <form action="#" class="form js-layout-form p-l-20">

                <!--Color mode  -->
                <div class="form-group m-t-20">
                    <label class="form-label"><?php echo lang("daynight_mode"); ?></label>
                    <div class="custom-controls-stacked">
                    <div class="row">
                        <div class="col-6">
                        <label class="form-check-inline custom-control-inline"><?php echo lang("day"); ?>
                            <input class="selectgroup-input" type="radio" name="color-scheme" value="light">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="col-6">
                        <label class="form-check-inline custom-control-inline"><?php echo lang("night"); ?>
                            <input class="selectgroup-input" type="radio" name="color-scheme" value="dark">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="form-group mb-2 d-none">
                    <label class="form-label">Nav position</label>
                    <div class="selectgroup w-100p">
                    <label class="selectgroup-item">
                        <input type="radio" name="nav-position" value="top" class="selectgroup-input">
                        <span class="selectgroup-button">top</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="nav-position" value="side" class="selectgroup-input">
                        <span class="selectgroup-button">side</span>
                    </label>
                    </div>
                </div>

                <div class="form-group mb-2 d-none">
                    <label class="form-label">Header color</label>
                    <div class="selectgroup w-100p">
                    <label class="selectgroup-item">
                        <input type="radio" name="header-color" value="light" class="selectgroup-input">
                        <span class="selectgroup-button">light</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="header-color" value="dark" class="selectgroup-input">
                        <span class="selectgroup-button">dark</span>
                    </label>
                    </div>
                </div>

                <!--</div>-->
                <div class="form-group mb-2 d-none">
                    <label class="form-label">Sidebar position</label>
                    <div class="selectgroup w-100p">
                    <label class="selectgroup-item">
                        <input type="radio" name="sidebar-position" value="left" class="selectgroup-input">
                        <span class="selectgroup-button">left</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="sidebar-position" value="right" class="selectgroup-input">
                        <span class="selectgroup-button">right</span>
                    </label>
                    </div>
                </div>

                <!--Layout Option-->
                <div class="form-group m-t-20">
                    <label class="form-label"><i class="fe fe-layout"></i> <?php echo lang("layout_option"); ?></label>
                    <div class="custom-controls-stacked">
                    <div class="row">
                        <div class="col-6">
                        <label class="form-check-inline custom-control-inline"><?php echo lang("expanded_menu"); ?>
                            <input class="selectgroup-input" type="radio" name="sidebar-size" value="default">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="col-6">
                        <label class="form-check-inline custom-control-inline"><?php echo lang("collapsed_menu"); ?>
                            <input class="selectgroup-input" type="radio" name="sidebar-size" value="folded">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                    </div>
                    </div>
                </div>

                <!--Sidebar color option-->
                <div class="form-group m-t-20">
                    <label class="form-label"><?php echo lang("sidebar_color_option"); ?></label>
                    <div class="custom-controls-stacked">
                    <div class="row">
                        <div class="col-6">
                        <label class="form-check-inline custom-control-inline"><?php echo lang("light"); ?>
                            <input class="selectgroup-input" type="radio" name="sidebar-color" value="light">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="col-6">
                        <label class="form-check-inline custom-control-inline"><?php echo lang("dark"); ?>
                            <input class="selectgroup-input" type="radio" name="sidebar-color" value="dark">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="form-group mb-2 d-none">
                    <label class="form-label">Sidebar fixed</label>
                    <div class="selectgroup w-100p">
                    <label class="selectgroup-item">
                        <input type="radio" name="sidebar-fixed" value="fixed" class="selectgroup-input">
                        <span class="selectgroup-button">fixed</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="sidebar-fixed" value="default" class="selectgroup-input">
                        <span class="selectgroup-button">default</span>
                    </label>
                    </div>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>