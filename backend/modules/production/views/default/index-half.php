<?php

?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Yii::t('app', 'Ishlab chiqarish') ?></li>
        <li class="breadcrumb-item active"><?= Yii::t('app', 'Ish stoli') ?></li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="/production/default/view-my-proccess" class="btn btn-success">
                <i class="icon-clock1"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="main-container">
    <div class="row">
        <div class="col-lg-6 col-12 offset-lg-3">
            <div class="card shadow-lg">
                <div class="card-body">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-around primary">
                            <!-- <li class="page-item btn-info shadow rounded-pill">
                                <a class="page-link" onclick="getNewJobsList()" title="<?= Yii::t('app', 'Yarimtayyor masulotlar') ?>">
                                    <i class="icon-open_in_new"></i>
                                </a>
                            </li> -->
                            <li class="page-item btn-warning shadow rounded-pill">
                                <a class="page-link" href="#" onclick="getAddList()" title="<?= Yii::t('app', 'Yangi ish qo`shish') ?>">
                                    <i class="icon-plus1"></i>
                                </a>
                            </li>
                            <li class="page-item btn-danger shadow rounded-pill">
                                <a class="page-link" href="#" title="<?= Yii::t('app', 'Jarimalar') ?>">
                                    <i class="icon-x-circle"></i>
                                </a>
                            </li>
                            <li class="page-item btn-success shadow rounded-pill ">
                                <a class="page-link" href="#" title="<?= Yii::t('app', 'Oylik hisobot') ?>">
                                    <i class="icon-bar-chart"></i>
                                </a>
                            </li>
                            <li class="page-item btn-success shadow rounded-pill ">
                                <a class="page-link" href="#" title="<?= Yii::t('app', 'Kunlik hisobot') ?>">
                                    <i class="icon-today"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row shadow-lg mt-5 p-3 w-100 mx-auto" id="myContent">
        
    </div>
</div>

<script>
    function getAddList() {
        var xhttp = new XMLHttpRequest()
        xhttp.open("GET", "/production/default/get-new-production", false);
        xhttp.send();
        document.getElementById("myContent").innerHTML = xhttp.responseText;
    }
</script>