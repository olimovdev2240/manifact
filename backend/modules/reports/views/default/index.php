<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <ul>
                <h3><?=Yii::t('app', 'Kassa')?></h3>
                <li><a href="/cost-types" class="btn btn-default"><?=Yii::t('app', 'Xarajat turlari')?></a></li>
                <li><a href="/reports/costs" class="btn btn-default"><?=Yii::t('app', 'Kassa harajatlari')?></a></li>
                <li><a href="/reports/office-debit" class="btn btn-default"><?=Yii::t('app', 'Kirim kassa')?></a></li>
                <li><a href="/reports/office-outlay" class="btn btn-default"><?=Yii::t('app', 'Chiqim kassa')?></a></li>
                <li><a href="/reports/office-to-office" class="btn btn-default"><?=Yii::t('app', 'Kassadan kassaga')?></a></li>
            </ul>
            <ul>
                <h3><?=Yii::t('app', 'Qoldiqlar')?></h3>
                <li><a href="/remains/workers" class="btn btn-default"><?=Yii::t('app', 'Ish haqi qoldiqlari')?></a></li>
                <li><a href="/remains/pay-offices" class="btn btn-default"><?=Yii::t('app', 'Pul qoldiqlari')?></a></li>
                <li><a href="/remains/contractors" class="btn btn-default"><?=Yii::t('app', 'Kontragent qoldiqlari')?></a></li>
                <li><a href="/remains/bases" class="btn btn-default"><?=Yii::t('app', 'Maxsulot qoldiqlari')?></a></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <ul>
                <h3><?=Yii::t('app', 'Omborlar')?></h3>
                <li><a href="/base/prebook" class="btn btn-default"><?=Yii::t('app', 'Bron qilish')?></a></li>
                <li><a href="/base/prebook-dispatch" class="btn btn-default"><?=Yii::t('app', 'Bronni yechish')?></a></li>
                <!-- <li><a href="/cost-types" class="btn btn-default"><?=Yii::t('app', 'Ishlab chiqarish')?></a></li> -->
                <li><a href="/base/base-to-base" class="btn btn-default"><?=Yii::t('app', 'Ombordan omborga')?></a></li>
                <li><a href="/base/return-supplier" class="btn btn-default"><?=Yii::t('app', 'Ta\'minotchiga vozvrat')?></a></li>
                <li><a href="/base/product-income" class="btn btn-default"><?=Yii::t('app', 'Tovar kirim')?></a></li>
                <!-- <li><a href="/cost-types" class="btn btn-default"><?=Yii::t('app', 'Xizmat kirim')?></a></li> -->
                <!-- <li><a href="/cost-types" class="btn btn-default"><?=Yii::t('app', 'Xizmat sotish')?></a></li> -->
                <li><a href="/base/inventarisation" class="btn btn-default"><?=Yii::t('app', 'Inventarizatsiya')?></a></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <ul>
                <h3><?=Yii::t('app', 'Sotuv')?></h3>
                <li><a href="/sale/product-sale" class="btn btn-default"><?=Yii::t('app', 'Sotish')?></a></li>
                <li><a href="/sale/return-customer" class="btn btn-default"><?=Yii::t('app', 'Xaridordan vozvrat')?></a></li>
            </ul>
        </div>
    </div>
</div>