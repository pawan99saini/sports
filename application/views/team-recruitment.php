<div class="dso-recruitment">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="dso-lg-content">
                    <h1>
                        <?= $teamData[0]->title; ?> 
                        <span>Recruitment</span>
                    </h1>
                    <p data-aos-delay="300" data-aos="fade-up">Looking forward to work with us?</p>
                </div>
            </div>

            <div class="col-md-7">
                <div class="dso-main-form">
                    <form action="<?= base_url(); ?>home/processApplication" enctype="multipart/form-data" class="apply-valorant" onsubmit="return false;">
                        <div id="msg-login"></div>

                        <div class="row">
                            <?php foreach($fieldsData as $fields): ?>
                            <div class="col-md-6">
                                <div class="form-group dso-animated-field-label">
                                    <?php if($fields->field_type != 'select') { ?>
                                    <label for="fname"><?= $fields->field_label; ?></label>
                                    <?php } ?>
                                    <?php 
                                        $is_required = ($fields->is_required == 0) ? '' : ' required';
                                        $placeholder = ($fields->placeholder_text == '') ? '' : ' placeholder="'.$fields->placeholder_text.'"';                                     
                                        $field_types_input = array('text', 'email', 'tel', 'date', 'time', 'file');
                                        
                                        if(in_array($fields->field_type, $field_types_input)) {
                                            echo '<input type="'.$fields->field_type.'" class="form-control" name="'.$fields->field_name.'" '.$is_required.' />';
                                        }

                                        if($fields->field_type == 'textarea') {
                                            echo '<textarea class="form-control" rows="6" name="'.$fields->field_name.'" '.$is_required . '></textarea>';
                                        }

                                        if($fields->field_type == 'select') {
                                            echo '<select name="'.$fields->field_name.'" class="form-control" '.$is_required . '>';

                                            $valuesData = unserialize($fields->field_values);
                                            echo '<option value="">--- Select ---</option>';
                                            foreach($valuesData as $value):
                                                echo '<option value="'.$value.'">'.$value.'</option>';
                                            endforeach;
                                            echo '</select>';
                                        }

                                        if($fields->field_type == 'radio') {
                                            $valuesData = unserialize($fields->field_values);
                        
                                            foreach($valuesData as $value):
                                                echo '<input type="'.$fields->field_type.'" class="form-control" name="'.$fields->field_name.'" '.$is_required.' value="'.$value.'" />';
                                            endforeach;
                                        }

                                        if($fields->field_type == 'checkbox') {
                                            foreach($valuesData as $value):
                                                echo '<input type="'.$fields->field_type.'" class="form-control" name="'.$fields->field_name.'[]" '.$is_required.' value="'.$value.'" />';
                                            endforeach;
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <input type="hidden" name="team" value="<?= $teamData[0]->ID; ?>" />

                            <div class="col-md-12">
                                <div class="dso-btn-row">
                                    <button type="submit" class="btn dso-ebtn dso-ebtn-solid register-btn">Submit</button>

                                    <div class="loader-sub" id="login-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>