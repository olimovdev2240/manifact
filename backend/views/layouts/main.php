<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\bootstrap5\Html;;
$worker  = Yii::$app->db->createCommand("SELECT * from workers WHERE user_id = " . Yii::$app->user->id)->queryOne();
AppAsset::register($this);
$product_remains = Yii::$app->db->createCommand("SELECT br.*, p.name_uz, SUM(br.qty) remains, p.notif notif FROM base_remains br LEFT JOIN products p ON p.id = br.product_id  GROUP BY br.product_id")->queryAll();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- Loading starts -->
    <div id="loading-wrapper">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Loading ends -->


    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Sidebar wrapper start -->
        <nav id="sidebar" class="sidebar-wrapper">
            <!-- Sidebar brand start  -->
            <div class="sidebar-brand">
                <a href="index.html" class="logo">
                    <img src="/img/logo.png" alt="Wafi Admin Dashboard" />
                </a>
                <a href="index.html" class="logo-sm">
                    <img src="/img/logo-sm.png" alt="Wafi Admin Dashboard" />
                </a>
            </div>
            <!-- Sidebar brand end  -->

            <!-- Sidebar content start -->
            <div class="sidebar-content">

                <!-- sidebar menu start -->
                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu"><?= Yii::t('app', 'Menyular') ?></li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-devices_other"></i>
                                <span class="menu-text"><?= Yii::t('app', 'Dashboard') ?></span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="/"><?= Yii::t('app', 'Oferta') ?></a>
                                    </li>
                                    <? if (Yii::$app->user->can('super admin')) : ?>
                                        <li>
                                            <a href="/reportdoc"><?= Yii::t('app', 'Hisobotlar') ?></a>
                                        </li>
                                        <li>
                                            <a href="/reportdoc/default/fee"><?= Yii::t('app', 'Narxlar hisoboti') ?></a>
                                        </li>
                                    <? endif ?>
                                </ul>
                            </div>
                        </li>
                        <? if (Yii::$app->user->can('omborchi')) : ?>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="icon-domain"></i>
                                    <span class="menu-text"><?= Yii::t('app', 'Ombor') ?></span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="/base"><?= Yii::t('app', 'Omborlarni boshqarish') ?></a>
                                        </li>
                                        <li>
                                            <a href="/base/base/incomes"><?= Yii::t('app', 'Maxsulot kirimlari') ?></a>
                                        </li>
                                        <li>
                                            <a href="/base/base/income"><?= Yii::t('app', 'Kirim qilish') ?></a>
                                        </li>
                                        <li>
                                            <a href="/base/products"><?= Yii::t('app', 'Maxsulotlar') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <? endif ?>
                        <? if (Yii::$app->user->can('Menejer')) : ?>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="icon-user1"></i>
                                    <span class="menu-text"><?= Yii::t('app', 'Kontragent') ?></span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="/contractors"><?= Yii::t('app', 'Kontragentlar') ?></a>
                                        </li>
                                        <li>
                                            <a href="/contractors-type"><?= Yii::t('app', 'Kontragentlar turi') ?></a>
                                        </li>
                                        <li>
                                            <a href="/contractors-group"><?= Yii::t('app', 'Kontragentlar-guruhi') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <? endif ?>
                        <? if (Yii::$app->user->can('Ishchi')) : ?>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="icon-domain"></i>
                                    <span class="menu-text"><?= Yii::t('app', 'Ishlab chiqarish') ?></span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <? if (Yii::$app->user->can('Dazmolchi')) : ?>
                                            <li>
                                                <a href="/production/default/packaging"><?= Yii::t('app', 'Qadoqlash') ?></a>
                                            </li>
                                        <? endif ?>
                                        <? if (Yii::$app->user->can('Ishchi')) : ?>
                                            <li>
                                                <a href="/production/default/production-half"><?= Yii::t('app', 'Yarimtayyor maxsulot') ?></a>
                                            </li>
                                        <? endif ?>
                                    </ul>
                                </div>
                            </li>
                        <? endif ?>
                        <? if (Yii::$app->user->can('Sanovchi')) : ?>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="icon-eye1"></i>
                                    <span class="menu-text"><?= Yii::t('app', 'Sifat nazorati') ?></span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="/production/default/production-manager"><?= Yii::t('app', 'Kiritish') ?></a>
                                        </li>
                                        <li>
                                            <a href="/production/production-proccess/half"><?= Yii::t('app', 'Yarimtayyor') ?></a>
                                        </li>
                                        <li>
                                            <a href="/production/production-proccess/full"><?= Yii::t('app', 'Tayyor') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <? endif ?>
                        <? if (Yii::$app->user->can('Menejer')) : ?>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="icon-assignment_turned_in"></i>
                                    <span class="menu-text"><?= Yii::t('app', 'Ishlab chiqarish boshqaruvi') ?></span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="/production/stages/list"><?= Yii::t('app', 'Etaplar') ?></a>
                                        </li>
                                        <li>
                                            <a href="/production/stages"><?= Yii::t('app', 'Etaplarni belgilash') ?></a>
                                        </li>
                                        <li>
                                            <a href="/production/pricing"><?= Yii::t('app', 'Narxlash') ?></a>
                                        </li>
                                        <li>
                                            <a href="/production/attach"><?= Yii::t('app', 'Homashyo biriktirish') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="icon-account_box"></i>
                                    <span class="menu-text"><?= Yii::t('app', 'Ishchilar boshqaruvi') ?></span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="/hr/workers"><?= Yii::t('app', 'Barcha ishchilar') ?></a>
                                        </li>
                                        <li>
                                            <a href="/hr/workers/add"><?= Yii::t('app', 'Ishchi qo`shish') ?></a>
                                        </li>
                                        <li>
                                            <a href="/reportdoc/salary"><?= Yii::t('app', 'Oylik hisoblash') ?></a>
                                        </li>
                                        <li>
                                            <a href="/hr/come-report"><?= Yii::t('app', 'Keldi ketti hisoboti') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <? endif ?>
                        <? if (Yii::$app->user->can('kassir')) : ?>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="icon-attach_money"></i>
                                    <span class="menu-text"><?= Yii::t('app', 'Kassalar boshqaruvi') ?></span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="/cost-types"><?= Yii::t('app', 'Xarajat turlari') ?></a>
                                        </li>
                                        <li>
                                            <a href="/reports/costs"><?= Yii::t('app', 'Oylik berish') ?></a>
                                        </li>
                                        <li>
                                            <a href="/reportdoc/salary"><?= Yii::t('app', 'Oylik hisoblash') ?></a>
                                        </li>
                                        <li>
                                            <a href="/reports/office-outlay"><?= Yii::t('app', 'Chiqim qilish') ?></a>
                                        </li>
                                        <li>
                                            <a href="/reports/office-debit"><?= Yii::t('app', 'Kirim qilish') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <? endif ?>
                        <? if (Yii::$app->user->can('Tashuvchi')) : ?>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="icon-backspace"></i>
                                    <span class="menu-text"><?= Yii::t('app', 'Sotuv bo`limi') ?></span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="/sale/product-sale"><?= Yii::t('app', 'Maxsulot sotish') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <? endif ?>
                        <!-- <li>
                            <a href="chat.html">
                                <i class="icon-message-circle"></i>
                                <span class="menu-text">Chat App</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-calendar1"></i>
                                <span class="menu-text">Calendars</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="calendar.html">Daygrid View</a>
                                    </li>
                                    <li>
                                        <a href="calendar-external-draggable.html">External Draggable</a>
                                    </li>
                                    <li>
                                        <a href="calendar-google.html">Google Calendar</a>
                                    </li>
                                    <li>
                                        <a href="calendar-list-view.html">List View</a>
                                    </li>
                                    <li>
                                        <a href="calendar-selectable.html">Selectable</a>
                                    </li>
                                    <li>
                                        <a href="calendar-week-numbers.html">Week Numbers</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="contacts.html">
                                <i class="icon-phone1"></i>
                                <span class="menu-text">Contacts List</span>
                            </a>
                        </li>
                        <li>
                            <a href="documents.html">
                                <i class="icon-documents"></i>
                                <span class="menu-text">Documents</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-layout"></i>
                                <span class="menu-text">Layouts</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="default-layout.html">Default Layout</a>
                                    </li>
                                    <li>
                                        <a href="default-light-layout.html">Default Light Version</a>
                                    </li>
                                    <li>
                                        <a href="fixed-layout.html">Fixed Layout</a>
                                    </li>
                                    <li>
                                        <a href="fixed-layout-light.html">Fixed Light Version</a>
                                    </li>
                                    <li>
                                        <a href="slim-sidebar.html">Slim Layout</a>
                                    </li>
                                    <li>
                                        <a href="slim-sidebar-light.html">Slim Light Version</a>
                                    </li>
                                    <li>
                                        <a href="card-options.html">Card Options</a>
                                    </li>
                                    <li>
                                        <a href="drag-drop-cards.html">Drag and Drop Cards</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-book-open"></i>
                                <span class="menu-text">Pages</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="account-settings.html">Account Settings</a>
                                    </li>
                                    <li>
                                        <a href="blog.html">Blog</a>
                                    </li>
                                    <li>
                                        <a href="cards.html">Cards</a>
                                    </li>
                                    <li>
                                        <a href="datepickers.html">Datepickers</a>
                                    </li>
                                    <li>
                                        <a href="faq.html">Faq</a>
                                    </li>
                                    <li>
                                        <a href="invoice.html">Invoice</a>
                                    </li>
                                    <li>
                                        <a href="search-results.html">Search Results</a>
                                    </li>
                                    <li>
                                        <a href="timeline.html">Timeline</a>
                                    </li>
                                    <li>
                                        <a href="comments.html">User Comments</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="pricing.html">
                                <i class="icon-dollar-sign"></i>
                                <span class="menu-text">Pricing Plans</span>
                            </a>
                        </li>
                        <li>
                            <a href="user-profile.html">
                                <i class="icon-user1"></i>
                                <span class="menu-text">User Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="tasks.html">
                                <i class="icon-check-circle"></i>
                                <span class="menu-text">Tasks App</span>
                            </a>
                        </li>
                        <li class="header-menu">Forms</li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-edit1"></i>
                                <span class="menu-text">Inputs</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="form-inputs.html">Form Inputs</a>
                                    </li>
                                    <li>
                                        <a href="input-groups.html">Input Groups</a>
                                    </li>
                                    <li>
                                        <a href="check-radio.html">Check Boxes</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-file-text"></i>
                                <span class="menu-text">Contact Forms</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="contact.html">Contact Form</a>
                                    </li>
                                    <li>
                                        <a href="contact2.html">Contact Form #2</a>
                                    </li>
                                    <li>
                                        <a href="contact3.html">Contact Form #3</a>
                                    </li>
                                    <li>
                                        <a href="contact4.html">Contact Form #4</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="bs-select.html">
                                <i class="icon-pocket"></i>
                                <span class="menu-text">BS Select</span>
                            </a>
                        </li>
                        <li>
                            <a href="editor.html">
                                <i class="icon-edit-3"></i>
                                <span class="menu-text">Editor</span>
                            </a>
                        </li>
                        <li>
                            <a href="input-masks.html">
                                <i class="icon-eye-off"></i>
                                <span class="menu-text">Input Masks</span>
                            </a>
                        </li>
                        <li>
                            <a href="input-tags.html">
                                <i class="icon-terminal"></i>
                                <span class="menu-text">Input Tags</span>
                            </a>
                        </li>
                        <li>
                            <a href="range-sliders.html">
                                <i class="icon-toggle-right"></i>
                                <span class="menu-text">Range Sliders</span>
                            </a>
                        </li>
                        <li>
                            <a href="wizard.html">
                                <i class="icon-triangle"></i>
                                <span class="menu-text">Wizards</span>
                            </a>
                        </li>
                        <li class="header-menu">UI Elements</li>
                        <li class="sidebar-dropdown active">
                            <a href="#">
                                <i class="icon-list2"></i>
                                <span class="menu-text">Accordions</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="accordion.html" class="current-page">Accordion</a>
                                    </li>
                                    <li>
                                        <a href="accordion-icons.html">Accordion Icons</a>
                                    </li>
                                    <li>
                                        <a href="accordion-arrows.html">Accordion Arrows</a>
                                    </li>
                                    <li>
                                        <a href="accordion-lg.html">Accordion Large</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-disc"></i>
                                <span class="menu-text">Buttons</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="buttons.html">Buttons</a>
                                    </li>
                                    <li>
                                        <a href="button-groups.html">Button Groups</a>
                                    </li>
                                    <li>
                                        <a href="dropdowns.html">Dropdowns</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="carousel.html">
                                <i class="icon-toll"></i>
                                <span class="menu-text">Carousels</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-star2"></i>
                                <span class="menu-text">Components</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="jumbotron.html">Jumbotron</a>
                                    </li>
                                    <li>
                                        <a href="labels-badges.html">Labels &amp; Badges</a>
                                    </li>
                                    <li>
                                        <a href="list-items.html">List Items</a>
                                    </li>
                                    <li>
                                        <a href="pagination.html">Paginations</a>
                                    </li>
                                    <li>
                                        <a href="progress.html">Progress Bars</a>
                                    </li>
                                    <li>
                                        <a href="pills.html">Pills</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-image"></i>
                                <span class="menu-text">Gallery</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="gallery.html">Gallery Slider</a>
                                    </li>
                                    <li>
                                        <a href="gallery2.html">Gallery Thumbnail</a>
                                    </li>
                                    <li>
                                        <a href="gallery3.html">Gallery Hover</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-box"></i>
                                <span class="menu-text">Grid</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="grid.html">Grid</a>
                                    </li>
                                    <li>
                                        <a href="grid-doc.html">Grid Doc</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="icons.html">
                                <i class="icon-timer"></i>
                                <span class="menu-text">Icons</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-image"></i>
                                <span class="menu-text">Images</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="avatars.html">Avatars</a>
                                    </li>
                                    <li>
                                        <a href="media-objects.html">Media Objects</a>
                                    </li>
                                    <li>
                                        <a href="images.html">Thumbnails</a>
                                    </li>
                                    <li>
                                        <a href="text-avatars.html">Text Avatars</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="modals.html">
                                <i class="icon-credit-card"></i>
                                <span class="menu-text">Modals</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-bell"></i>
                                <span class="menu-text">Notifications</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="bootstrap-alerts.html">Default Alerts</a>
                                    </li>
                                    <li>
                                        <a href="custom-alerts.html">Custom Alerts</a>
                                    </li>
                                    <li>
                                        <a href="toasts.html">Toasts</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="spinners.html">
                                <i class="icon-circular-graph"></i>
                                <span class="menu-text">Spinners</span>
                            </a>
                        </li>
                        <li>
                            <a href="tooltips.html">
                                <i class="icon-change_history"></i>
                                <span class="menu-text">Tooltips</span>
                            </a>
                        </li>
                        <li>
                            <a href="typography.html">
                                <i class="icon-sort_by_alpha"></i>
                                <span class="menu-text">Typography</span>
                            </a>
                        </li>
                        <li class="header-menu">Tables</li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-border_all"></i>
                                <span class="menu-text">Tables</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="custom-tables.html">Custom Tables</a>
                                    </li>
                                    <li>
                                        <a href="default-table.html">Default Table</a>
                                    </li>
                                    <li>
                                        <a href="table-bordered.html">Table Bordered</a>
                                    </li>
                                    <li>
                                        <a href="table-hover.html">Table Hover</a>
                                    </li>
                                    <li>
                                        <a href="table-striped.html">Table Striped</a>
                                    </li>
                                    <li>
                                        <a href="table-small.html">Table Small</a>
                                    </li>
                                    <li>
                                        <a href="table-colors.html">Table Colors</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="data-tables.html">
                                <i class="icon-border_all"></i>
                                <span class="menu-text">Data Tables</span>
                            </a>
                        </li>
                        <li class="header-menu">Graphs &amp; Maps</li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-line-graph"></i>
                                <span class="menu-text">Apex Graphs</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="area-graphs.html">Area Charts</a>
                                    </li>
                                    <li>
                                        <a href="bubble.html">Bubble Graphs</a>
                                    </li>
                                    <li>
                                        <a href="bar-graphs.html">Bar Charts</a>
                                    </li>
                                    <li>
                                        <a href="candlestick.html">Candlestick</a>
                                    </li>
                                    <li>
                                        <a href="column-graphs.html">Column Charts</a>
                                    </li>
                                    <li>
                                        <a href="donut-graphs.html">Donut Charts</a>
                                    </li>
                                    <li>
                                        <a href="line-graphs.html">Line Charts</a>
                                    </li>
                                    <li>
                                        <a href="mixed-graphs.html">Mixed Charts</a>
                                    </li>
                                    <li>
                                        <a href="pie-graphs.html">Pie Charts</a>
                                    </li>
                                    <li>
                                        <a href="radial-chart.html">Radial Graph</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="morris-graphs.html">
                                <i class="icon-tonality"></i>
                                <span class="menu-text">Morris Graphs</span>
                            </a>
                        </li>
                        <li>
                            <a href="flot-graphs.html">
                                <i class="icon-pie_chart_outlined"></i>
                                <span class="menu-text">Flot Graphs</span>
                            </a>
                        </li>
                        <li>
                            <a href="c3-graphs.html">
                                <i class="icon-activity"></i>
                                <span class="menu-text">C3 Graphs</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-map2"></i>
                                <span class="menu-text">Maps</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="vector-maps.html">Vector Maps</a>
                                    </li>
                                    <li>
                                        <a href="google-maps.html">Google Maps</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="header-menu">Extra</li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-airplay"></i>
                                <span class="menu-text">Login</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="login.html">Login</a>
                                    </li>
                                    <li>
                                        <a href="signup.html">Signup</a>
                                    </li>
                                    <li>
                                        <a href="forgot-pwd.html">Forgot Password</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-mail"></i>
                                <span class="menu-text">Subscribe</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="subscribe.html">Subscribe 1</a>
                                    </li>
                                    <li>
                                        <a href="subscribe2.html">Subscribe 2</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="icon-alert-triangle"></i>
                                <span class="menu-text">Error Pages</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="error.html">404</a>
                                    </li>
                                    <li>
                                        <a href="error2.html">505</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="coming-soon.html">
                                <i class="icon-schedule"></i>
                                <span class="menu-text">Coming Soon</span>
                            </a>
                        </li> -->
                    </ul>
                </div>
                <!-- sidebar menu end -->

            </div>
            <!-- Sidebar content end -->
        </nav>
        <!-- Sidebar wrapper end -->
        <!-- Page content start  -->
        <div class="page-content">

            <!-- Header start -->
            <header class="header">
                <div class="toggle-btns">
                    <a id="toggle-sidebar" href="#">
                        <i class="icon-list"></i>
                    </a>
                    <a id="pin-sidebar" href="#">
                        <i class="icon-list"></i>
                    </a>
                </div>
                <div class="header-items">

                    <!-- Header actions start -->
                    <ul class="header-actions">
                        <li class="dropdown">
                            <a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                                <i class="icon-box"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
                                <div class="dropdown-menu-header">
                                    <?= Yii::t('app', "Kam qolgan maxsulotlar") ?>
                                </div>
                                <ul class="header-tasks">
                                    <? foreach ($product_remains as $pr) : ?>
                                        <? if ($pr['remains'] <= $pr['notif'] && $pr['notif'] != 0) : ?>
                                            <li>
                                                <p><?= $pr['name_uz'] ?></p>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?= round($pr['remains'] / $pr['notif']) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($pr['remains'] / $pr['notif']) ?>%">
                                                        <span class="sr-only">90% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </li>
                                        <? endif ?>
                                    <? endforeach ?>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                                <i class="icon-bell"></i>
                                <span class="count-label">8</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
                                <div class="dropdown-menu-header">
                                    <?= Yii::t('app', 'So`nggi o`zgarishlar') ?>
                                </div>
                                <ul class="header-notifications">
                                    <li>
                                        <a href="#">
                                            <div class="user-img away">
                                                <img src="img/user21.png" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="user-title">Abbott</div>
                                                <div class="noti-details">Membership has been ended.</div>
                                                <div class="noti-date">Oct 20, 07:30 pm</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                <span class="user-name"><?= Yii::$app->user->identity->username ?></span>
                                <span class="avatar"><i class="icon-settings1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                                <div class="header-profile-actions">
                                    <div class="header-user-profile">
                                        <div class="header-user">
                                            <img src="/workers/<?= $worker['photo'] ?>" alt="Admin Template">
                                        </div>
                                        <h5><?= $worker['full_name'] ?></h5>
                                    </div>
                                    <a href="user-profile.html"><i class="icon-user1"></i> My Profile</a>
                                    <a href="account-settings.html"><i class="icon-settings1"></i> Account Settings</a>
                                    <a href="/site/logout"><i class="icon-log-out1"></i> <?= Yii::t('app', 'Profildan chiqish') ?></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- Header actions end -->
                </div>
            </header>
            <!-- Header end -->

            <?= $content ?>

        </div>
        <!-- Page content end -->
        <?= \lavrentiev\widgets\toastr\NotificationFlash::widget([
            'options' => [
                "closeButton" => true,
                "debug" => false,
                "newestOnTop" => false,
                "progressBar" => false,
                "positionClass" => \lavrentiev\widgets\toastr\NotificationFlash::POSITION_TOP_RIGHT,
                "preventDuplicates" => false,
                "onclick" => null,
                "showDuration" => "300",
                "hideDuration" => "1000",
                "timeOut" => "5000",
                "extendedTimeOut" => "1000",
                "showEasing" => "swing",
                "hideEasing" => "linear",
                "showMethod" => "fadeIn",
                "hideMethod" => "fadeOut"
            ]
        ]) ?>


    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
