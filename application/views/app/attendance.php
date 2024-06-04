<div class="page-wrapper">
    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Attendance</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>member">Dashboard</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">View Attendance</h4>
                        
                        <div class="calendar-area"> 
                            <div class="status-report">
                                <div class="rep-header">
                                    <h4 class="card-title">
                                        <i class="ti-id-badge"></i> Status Report

                                        <div class="btnChange">
                                            <div class="btn-box">
                                                <a href="<?= base_url(); ?>member/getNextWeek" class="getDate" data-get="-"><</a>
                                                <a href="<?= base_url(); ?>member/getNextWeek" class="getDate" data-get="+">></a>
                                            </div>

                                            <div class="date-box">
                                                <span>
                                                <?= $dayFrom . ' - ' . $dayTo; ?>
                                                </span>
                                                <i class="ti-calendar"></i> 
                                            </div>
                                        </div>
                                    </h4>
                                </div>

                                <div class="loader-wrapper">
                                    <div class="loader-sub" id="report-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="calendar-wrapper">
                                <div class="time-calendar">
                                    <div class="date-header">
                                        <ul>
                                        <?= $data_header; ?>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="start_date" value="<?= $start_date; ?>" />
                                    <input type="hidden" name="end_date" value="<?= $end_date; ?>" />
                                    <input type="hidden" name="daysToShow" value="<?= $date; ?>" />
                                    <input type="hidden" name="datePrevious" value="<?= $dateGet; ?>" />

                                    <div class="timeAreaWrapper">
                                        <ul class="timeArea">
                                        <?= $calendarData; ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="reportData">
                                    <?= $reportData; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>" />
        <!-- End PAge Content -->
    </div>
</div>