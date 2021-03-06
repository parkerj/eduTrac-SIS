<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 * View Academic Program View
 *
 * @license GPLv3
 * 
 * @since       3.0.0
 * @package     eduTrac SIS
 * @author      Joshua Parker <joshmac3@icloud.com>
 */
$app = \Liten\Liten::getInstance();
$app->view->extend('_layouts/dashboard');
$app->view->block('dashboard');
include('ajax.php');
$screen = 'vprog';
?>

<ul class="breadcrumb">
    <li><?=_t( 'You are here' );?></li>
    <li><a href="<?=get_base_url();?>dashboard/" class="glyphicons dashboard"><i></i> <?=_t( 'Dashboard' );?></a></li>
    <li class="divider"></li>
    <li><a href="<?=get_base_url();?>program/" class="glyphicons search"><i></i> <?=_t( 'Search Program' );?></a></li>
    <li class="divider"></li>
    <li><?=_t( 'View Program' );?></li>
</ul>

<h3><?=_h($prog->acadProgCode);?>
    <span data-toggle="tooltip" data-original-title="Create Program" data-placement="top">
        <a<?=ae('add_acad_prog');?> href="<?=get_base_url();?>program/add/" class="btn btn-primary"><i class="fa fa-plus"></i></a>
    </span>
</h3>
<div class="innerLR">
	
	<?=_etsis_flash()->showMessage();?>
    
    <?php jstree_sidebar_menu($screen,'','','','','',$prog); ?>

    <!-- Form -->
    <form class="form-horizontal margin-none" action="<?=get_base_url();?>program/<?=_h($prog->id);?>/" id="validateSubmitForm" method="post" autocomplete="off">
        
        <!-- Widget -->
        <div class="widget widget-heading-simple widget-body-gray <?=($app->hook->has_filter('sidebar_menu')) ? 'col-md-12' : 'col-md-10';?>">
        
            <!-- Widget heading -->
            <div class="widget-head">
                <h4 class="heading"><font color="red">*</font> <?=_t( 'Indicates field is required' );?></h4>
            </div>
            <!-- // Widget heading END -->
            
            <div class="widget-body">
            
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-6">
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> <?=_t( 'Program Code' );?></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="acadProgCode"<?=apio();?> value="<?=_h($prog->acadProgCode);?>" required />
                            </div>
                        </div>
                        <!-- // Group END -->
                    
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> <?=_t( 'Title' );?></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="acadProgTitle"<?=apio();?> value="<?=_h($prog->acadProgTitle);?>" required />
                            </div>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> <?=_t( 'Short Description' );?></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="programDesc"<?=apio();?> value="<?=_h($prog->programDesc);?>" required />
                            </div>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> <?=_t( 'Status / Date' );?></label>
                            <div class="col-md-4">
                                <?=status_select(_h($prog->currStatus), csid());?>
                            </div>
                            
                            <div class="col-md-4">
                                <input class="form-control" name="statusDate" type="text" readonly value="<?=\Jenssegers\Date\Date::parse(_h($prog->statusDate))->format('D, M d, o');?>" />
                            </div>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'Approval Person' );?></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly value="<?=get_name(_h($prog->approvedBy));?>" />
                            </div>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'Approval Date' );?></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" readonly value="<?=\Jenssegers\Date\Date::parse(_h($prog->approvedDate))->format("D, M d, o");?>" />
                            </div>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'Department' );?></label>
                            <div class="col-md-8" id="divDept">
                                <select name="deptCode" id="deptCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?>>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('department','deptCode <> "NULL"','deptCode','deptCode','deptName',_h($prog->deptCode));?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#dept" data-toggle="modal" title="Department" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'School' );?></label>
                            <div class="col-md-8">
                                <select name="schoolCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?>>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('school','schoolCode <> "NULL"','schoolCode','schoolCode','schoolName',_h($prog->schoolCode));?>
                                </select>
                            </div>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> <?=_t( 'Effective Catalog Year' );?></label>
                            <div class="col-md-8" id="divYear">
                                <select name="acadYearCode" id="acadYearCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?> required>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('acad_year','acadYearCode <> "NULL"','acadYearCode','acadYearCode','acadYearDesc',_h($prog->acadYearCode));?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#year" data-toggle="modal" title="Academic Year" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <?php 
                        /**
                         * Prints a new field on the left of the screen
                         * when fired.
                         * 
                         * @since 6.1.06
                         * @param array $prog Current program data object.
                         */
                        $app->hook->do_action('left_prog_view_form', $prog); 
                        ?>
                        
                    </div>
                    <!-- // Column END -->
                    
                    <!-- Column -->
                    <div class="col-md-6">
                    
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> <?=_t( 'Effective / End Date' );?></label>
                            <div class="col-md-4">
                                <div class="input-group date col-md-12" id="datepicker6">
                                    <input class="form-control"<?=apio();?> name="startDate" type="text" value="<?=_h($prog->startDate);?>" required />
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="input-group date col-md-12" id="datepicker7">
                                    <input class="form-control"<?=apio();?> name="endDate" type="text" value="<?=(_h($prog->endDate) > '0000-00-00' ? _h($prog->endDate) : '');?>" />
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> <?=_t( 'Degree' );?></label>
                            <div class="col-md-8" id="divDegree">
                                <select name="degreeCode" id="degreeCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?> required>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('degree','degreeCode <> "NULL"','degreeCode','degreeCode','degreeName',_h($prog->degreeCode));?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#degree" data-toggle="modal" title="Degree" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'CCD' );?></label>
                            <div class="col-md-8" id="divCCD">
                                <select name="ccdCode" id="ccdCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?>>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('ccd','ccdCode <> "NULL"','ccdCode','ccdCode','ccdName',_h($prog->ccdCode));?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#ccd" data-toggle="modal" title="CCD" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'Major' );?></label>
                            <div class="col-md-8" id="divMajor">
                                <select name="majorCode" id="majorCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?>>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('major','majorCode <> "NULL"','majorCode','majorCode','majorName',_h($prog->majorCode));?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#major" data-toggle="modal" title="Major" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'Minor' );?></label>
                            <div class="col-md-8" id="divMinor">
                                <select name="minorCode" id="minorCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?>>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('minor','minorCode <> "NULL"','minorCode','minorCode','minorName',_h($prog->minorCode));?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#minor" data-toggle="modal" title="Minor" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'Specialization' );?></label>
                            <div class="col-md-8" id="divSpec">
                                <select name="specCode" id="specCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?>>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('specialization', 'specCode <> "NULL"', 'specCode', 'specCode', 'specName',_h($prog->specCode)); ?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#spec" data-toggle="modal" title="Specialization" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> <?=_t( 'Academic Level' );?></label>
                            <div class="col-md-8">
                                <select name="acadLevelCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=csid();?> required>
                                    <option value="">&nbsp;</option>
                                    <?php table_dropdown('aclv',null,'code','code','name',_h($prog->acadLevelCode)); ?>
                                </select>
                            </div>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'CIP' );?></label>
                            <div class="col-md-8" id="divCIP">
                                <select name="cipCode" id="cipCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?>>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('cip','cipCode <> "NULL"','cipCode','cipCode','cipName',_h($prog->cipCode));?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#cip" data-toggle="modal" title="CIP" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <!-- Group -->
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?=_t( 'Location' );?></label>
                            <div class="col-md-8" id="divLoc">
                                <select name="locationCode" id="locationCode" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true"<?=apid();?>>
                                    <option value="NULL">&nbsp;</option>
                                    <?php table_dropdown('location','locationCode <> "NULL"','locationCode','locationCode','locationName',_h($prog->locationCode));?>
                                </select>
                            </div>
                            <a<?=ae('access_forms');?> href="#loc" data-toggle="modal" title="Location" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                        </div>
                        <!-- // Group END -->
                        
                        <?php 
                        /**
                         * Prints a field on the right of the screen
                         * when fired.
                         * 
                         * @since 6.1.06
                         * @param array $prog Current program data object.
                         */
                        $app->hook->do_action('right_prog_view_form', $prog); 
                        ?>
                        
                    </div>
                    <!-- // Column END -->
                </div>
                <!-- // Row END -->
            
                <hr class="separator" />
                
                <!-- Form actions -->
                <div class="form-actions">
                    <input class="form-control" type="hidden" name="id" value="<?=_h($prog->id);?>" />
                    <button type="submit"<?=apids();?> class="btn btn-icon btn-primary glyphicons circle_ok"><i></i><?=_t( 'Save' );?></button>
                    <button type="button" class="btn btn-icon btn-primary glyphicons circle_minus" onclick="window.location='<?=get_base_url();?>program/'"><i></i><?=_t( 'Cancel' );?></button>
                </div>
                <!-- // Form actions END -->
                
            </div>
        </div>
        <!-- // Widget END -->
        
    </form>
    <!-- // Form END -->
    
</div>  
        
        </div>
        <!-- // Content END -->
<?php $app->view->stop(); ?>