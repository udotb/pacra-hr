<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8"/>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('img/favicon.png')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('appointmentLetter/base.min.css')); ?>"/>
<link rel="stylesheet" href="<?php echo e(asset('appointmentLetter/fancy.min.css')); ?>"/>
<link rel="stylesheet" href="<?php echo e(asset('appointmentLetter/main.css')); ?>"/>
<script src="<?php echo e(asset('appointmentLetter/compatibility.min.js')); ?>"></script>
<script src="<?php echo e(asset('appointmentLetter/theViewer.min.js')); ?>"></script>
<script>
try{
theViewer.defaultViewer = new theViewer.Viewer({});
}catch(e){}
</script>
<title><?php echo e(!empty($meta_title) ? $meta_title: 'PACRA'); ?></title>
</head>
<body>
<div id="sidebar">
<div id="outline">
</div>
</div>
<div id="page-container">
<div id="pf1" class="pf w0 h0" data-page-no="1">


    <?php if($getProfileDetails->first()->status =='entered'): ?>
    <div class="pc pc1 w0 h0"><img class="bi x0 y0 w1 h1" alt="" src="<?php echo e(asset('appointmentLetter/bg2.png')); ?>"/>

    <?php elseif($getProfileDetails->first()->status =='approved'): ?>
    <div class="pc pc1 w0 h0"><img class="bi x0 y0 w1 h1" alt="" src="<?php echo e(asset('appointmentLetter/bg1.png')); ?>"/>

    <?php endif; ?>

        <div class="c x1 y1 w2 h0">
            <div class="t m0 x2 h2 y2 ff1 fs0 fc0 sc0 ls0 ws0">
            </div>
            <div class="t m0 x3 h3 y3 ff2 fs1 fc1 sc0 ls0 ws0">T<span class="fs0">HE </span>P<span class="fs0">AKISTAN <span class="_ _0"></span><span class="fs1">C<span class="fs0">REDIT </span>R<span class="fs0">ATING </span>A<span class="_ _0"></span><span class="fs0">GENCY <span class="fs1">L</span>IMITED<span class="_ _0"></span><span class="fs1"> </span></span></span></span>
            </div>
            <div class="t m0 x4 h4 y4 ff2 fs2 fc1 sc0 ls0 ws0">
            </div>
        </div>
        <div class="c x5 y5 w3 h5">
            <div class="t m0 x6 h6 y6 ff2 fs3 fc0 sc0 ls0 ws0">The Pakistan C<span class="_ _0"></span>redit Ratin<span class="_ _0"></span>g Agency Limited<span class="_ _0"></span> [PACRA] </div>
            <div class="t m0 x6 h7 y7 ff3 fs3 fc0 sc0 ls0 ws0">Lahore <span class="_ _1"> </span>| FB-1, Awami C<span class="_ _0"></span>omplex, Usman <span class="_ _0"></span>Block, New Gard<span class="_ _0"></span>en Town  </div>
            <div class="t m0 x6 h7 y8 ff3 fs3 fc0 sc0 ls0 ws0">Karachi <span class="_ _2"></span>| 3</div>
            <div class="t m0 x7 h8 y9 ff3 fs4 fc0 sc0 ls1 ws0">rd</div>
            <div class="t m0 x8 h7 y8 ff3 fs3 fc0 sc0 ls0 ws0"> Floor, PNS<span class="_ _0"></span>C Building, MT<span class="_ _0"></span> Khan Road </div>
        </div>
        <div class="c x9 y5 w4 h5">
            <div class="t m0 xa h7 y6 ff3 fs3 fc0 sc0 ls0 ws0">
            </div>
            <div class="t m0 x3 h7 y7 ff3 fs3 fc0 sc0 ls0 ws0">+<span class="ls2">92</span> (42) 3586 9504
            </div>
            <div class="t m0 xb h6 y8 ff3 fs3 fc0 sc0 ls3 ws0">www.<span class="ff2 ls0">pacra<span class="ff3">.com </span></span>
            </div>
        </div>
        <div class="c x1 y1 w2 h0">
            <div class="t m0 x5 h2 ya ff1 fs0 fc0 sc0 ls0 ws0"> </div>
            <div class="t m0 x5 h9 yb ff3 fs5 fc0 sc0 ls0 ws0">Ref: <?php echo e($getProfileDetails->first()->refrence); ?> <span class="_ _3"> </span> <span class="_ _4"> </span> <span class="_ _4"> </span> <span class="_ _4"> </span> <span class="_ _4"> </span> <span class="_ _4"> </span>                          <span class="_ _0"></span>              <span class="_ _5"> </span>            <span class="_ _6"> </span><?php echo e(date('d-M-y', strtotime($getProfileDetails->first()->date))); ?> </div>
            <div class="t m0 x5 h9 yc ff3 fs5 fc0 sc0 ls0 ws0">Employee No.: <?php echo e($getProfileDetails->first()->candidateEmpNo); ?> </div>
            <div class="t m0 x5 h9 yd ff3 fs5 fc0 sc0 ls0 ws0">Grade: <span class="ls4"><?php echo e($getProfileDetails->first()->gradeTitle); ?><span class="_ _0"></span><span class="ls0"> </span></span>
            </div>
            <div class="t m0 x5 h9 ye ff3 fs5 fc0 sc0 ls0 ws0"> </div>
            <div class="t m0 x5 ha yf ff2 fs5 fc0 sc0 ls0 ws0"><?php echo e($getProfileDetails->first()->fname); ?> <?php echo e($getProfileDetails->first()->lname); ?> </div>
            <div class="t m0 x5 h9 y10 ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($getProfileDetails->first()->email); ?></div>
            <div class="t m0 x5 h9 y11 ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($getProfileDetails->first()->contactNumber); ?></div>
            <div class="t m0 xc hb y12 ff2 fs6 fc0 sc0 ls0 ws0">Appointment Letter </div>
            <div class="t m0 x5 ha y13 ff3 fs5 fc0 sc0 ls0 ws0">Dear <span class="ff2"><?php echo e($getProfileDetails->first()->fname); ?> <?php echo e($getProfileDetails->first()->lname); ?><span>
            </div>

            <div class="t m0 x5 h9 y14 ff3 fs5 fc0 sc0 ls0 ws0"> </div>
            <div class="t m0 x5 ha y15 ff4 fs5 fc0 sc0 ls0 ws0">We are pleased to offer you the position of “<span class="ff2"><?php echo e($getProfileDetails->first()->desigTitle); ?></span>”. Your monthly salary package will be as under:<span class="ff3"> </span>
            </div>
            <div class="t m0 x5 h9 y16 ff3 fs5 fc0 sc0 ls0 ws0"> </div>
        </div>
        <div class="c x5 y17 w5 hc">
            <div class="t m0 xd hd y18 ff2 fs7 fc0 sc0 ls0 ws0">Description       <span class="_ _2"></span>
            </div>
            <div class="t m0 xd hd y19 ff2 fs7 fc0 sc0 ls0 ws0">(Amount in PK<span class="_ _2"></span>R)                    <span class="_ _2"></span>
            </div>
        </div>
        <div class="c xe y17 w6 hc">
            <div class="t m0 xf hd y1a ff2 fs7 fc0 sc0 ls0 ws0">

            </div>
        </div>
        <div class="c x10 y17 w7 hc">
            <div class="t m0 x11 he y1b ff5 fs7 fc0 sc0 ls0 ws0">During </div>
            <div class="t m0 x12 he y1c ff5 fs7 fc0 sc0 ls0 ws0">Probation </div>
        </div>
        <div class="c x13 y17 w8 hc">
            <div class="t m0 x14 he y1b ff5 fs7 fc0 sc0 ls0 ws0">On </div>
            <div class="t m0 x15 he y1c ff5 fs7 fc0 sc0 ls0 ws0">Confirmation<span class="_ _2"></span> </div>
        </div>
        <div class="c x5 y1d w5 hf">
            <div class="t m0 xd h9 y1e ff3 fs5 fc0 sc0 ls0 ws0">Basic Salary </div>
        </div>
        <div class="c xe y1d w6 hf">
            <div class="t m0 xd h9 y1f ff3 fs5 fc0 sc0 ls0 ws0"> </div>
        </div>
        <div class="c x10 y1d w7 hf"><div class="t m0 x16 h9 y1e ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($getProfileDetails->first()->probBasicSalary-$eobiEmployer); ?> </div></div><div class="c x13 y1d w8 hf"><div class="t m0 x16 h9 y1e ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($getProfileDetails->first()->confirmationSalary-$eobiEmployer-$confirmEmployerPF-$confirmMedical); ?> </div></div><div class="c x5 y20 w5 hf"><div class="t m0 xd h9 y1e ff3 fs5 fc0 sc0 ls0 ws0">Medical Allowance | 10% of Basic Salary </div></div><div class="c xe y20 w6 hf"><div class="t m0 xd h9 y1f ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y20 w7 hf"><div class="t m0 x16 h9 y1e ff3 fs5 fc0 sc0 ls0 ws0">- </div></div><div class="c x13 y20 w8 hf"><div class="t m0 x16 h9 y1e ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($confirmMedical); ?> </div></div><div class="c x5 y21 w5 hf"><div class="t m0 xd h9 y1e ff4 fs5 fc0 sc0 ls0 ws0">Provident Fund | Employer’s <span class="ff3">Contribution - 5% of Basic Salary </span></div></div><div class="c xe y21 w6 hf"><div class="t m0 xd h9 y1f ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y21 w7 hf"><div class="t m0 x17 h9 y1e ff3 fs5 fc0 sc0 ls0 ws0">- </div></div><div class="c x13 y21 w8 hf"><div class="t m0 x17 h9 y1e ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($confirmEmployerPF); ?> </div></div><div class="c x5 y22 w5 h10"><div class="t m0 xd h9 y23 ff4 fs5 fc0 sc0 ls0 ws0">EOBI | Employer’s Contribution <span class="ff3"> </span></div></div><div class="c xe y22 w6 h10"><div class="t m0 xd h9 y1f ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y22 w7 h10"><div class="t m0 x17 h9 y23 ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($eobiEmployer); ?> </div></div><div class="c x13 y22 w8 h10"><div class="t m0 x17 h9 y23 ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($eobiEmployer); ?> </div></div><div class="c x5 y24 w5 h11"><div class="t m0 xd ha y25 ff2 fs5 fc0 sc0 ls0 ws0">Total Salary  </div></div><div class="c xe y24 w6 h11"><div class="t m0 xd ha y26 ff2 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y24 w7 h11"><div class="t m0 x16 ha y25 ff2 fs5 fc0 sc0 ls0 ws0"><?php echo e($getProfileDetails->first()->probBasicSalary); ?> </div></div><div class="c x13 y24 w8 h11"><div class="t m0 x16 ha y25 ff2 fs5 fc0 sc0 ls0 ws0"><?php echo e($getProfileDetails->first()->confirmationSalary); ?> </div></div><div class="c x5 y27 w5 h12"><div class="t m0 x18 ha y1 ff2 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c xe y27 w6 h12"><div class="t m0 xd h9 y1 ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y27 w7 h12"><div class="t m0 xd h9 y1 ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x13 y27 w8 h12"><div class="t m0 xd h9 y1 ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x5 y28 w5 h13"><div class="t m0 xd ha y1c ff2 fs5 fc0 sc0 ls0 ws0">Contributions </div></div><div class="c xe y28 w6 h13"><div class="t m0 xd ha y29 ff2 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y28 w7 h13"><div class="t m0 x19 h9 y1c ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x13 y28 w8 h13"><div class="t m0 x19 h9 y1c ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x5 y2a w5 h14"><div class="t m0 xd ha y1c ff2 fs5 fc0 sc0 ls0 ws0">Provident Fund </div></div><div class="c xe y2a w6 h14"><div class="t m0 xd h9 y2b ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y2a w7 h14"><div class="t m0 x19 h9 y1c ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x13 y2a w8 h14"><div class="t m0 x19 h9 y1c ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x5 y2c w5 h10"><div class="t m0 xd h9 y23 ff3 fs5 fc0 sc0 ls0 ws0">Employee Contribution - 5% <span class="ff6">(to be contributed from Basic Salary)</span> </div></div><div class="c xe y2c w6 h10"><div class="t m0 xd h9 y1f ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y2c w9 h10"><div class="t m0 x17 h9 y23 ff3 fs5 fc0 sc0 ls0 ws0">- </div></div><div class="c x13 y2c wa h10"><div class="t m0 x17 h9 y23 ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($confirmEmployerPF); ?> </div></div><div class="c x5 y2d w5 h15"><div class="t m0 xd h9 y2e ff3 fs5 fc0 sc0 ls0 ws0">Employer Contribution - 5%  </div></div><div class="c xe y2d w6 h15"><div class="t m0 xd h9 y2f ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y2d w9 h15"><div class="t m0 x17 h9 y2e ff3 fs5 fc0 sc0 ls0 ws0">- </div></div><div class="c x13 y2d wa h15"><div class="t m0 x17 h9 y2e ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($confirmEmployerPF); ?> </div></div><div class="c x5 y30 w5 h16"><div class="t m0 x18 h9 y31 ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c xe y30 w6 h16"><div class="t m0 xd h9 y31 ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y30 w7 h16"><div class="t m0 x17 h9 ya ff3 fs5 fc0 sc0 ls0 ws0">- </div></div><div class="c x13 y30 w8 h16"><div class="t m0 x17 h9 ya ff3 fs5 fc0 sc0 ls0 ws0"><?php echo e($confirmEmployerPF+$confirmEmployerPF); ?> </div></div><div class="c x5 y32 w5 h17"><div class="t m0 xd ha y33 ff2 fs5 fc0 sc0 ls0 ws0">EOBI </div></div><div class="c xe y32 w6 h17"><div class="t m0 xd ha y34 ff2 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y32 w7 h17"><div class="t m0 x19 h9 y34 ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x13 y32 w8 h17"><div class="t m0 x19 h9 y34 ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x5 y35 w5 h18"><div class="t m0 xd h9 y36 ff3 fs5 fc0 sc0 ls0 ws0">Employee Contribution <span class="ff6">(to be contributed from Basic Salary)</span> </div></div><div class="c xe y35 w6 h18"><div class="t m0 xd h9 y37 ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y35 w9 h18"><div class="t m0 x1a h9 y36 ff3 fs5 fc0 sc0 ls5 ws0"><?php echo e($getProfileDetails->first()->probEOBIEmployee); ?><span class="ls0"> </span></div></div><div class="c x13 y35 wa h18"><div class="t m0 x1a h9 y36 ff3 fs5 fc0 sc0 ls5 ws0"><?php echo e($getProfileDetails->first()->confirmationEOBIEmployee); ?><span class="ls0"> </span></div></div><div class="c x5 y38 w5 h19"><div class="t m0 xd h9 y39 ff3 fs5 fc0 sc0 ls0 ws0">Employer Contribution  </div></div><div class="c xe y38 w6 h19"><div class="t m0 xd h9 y3a ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c x10 y38 w9 h19"><div class="t m0 x1a h9 y39 ff3 fs5 fc0 sc0 ls5 ws0"><?php echo e($getProfileDetails->first()->probEOBIEmployer); ?><span class="ls0"> </span></div></div><div class="c x13 y38 wa h19"><div class="t m0 x1a h9 y39 ff3 fs5 fc0 sc0 ls5 ws0"><?php echo e($getProfileDetails->first()->confirmationEOBIEmployer); ?><span class="ls0"> </span></div></div><div class="c x5 y3b w5 h1a"><div class="t m0 x18 h9 y3c ff3 fs5 fc0 sc0 ls0 ws0"> </div></div><div class="c xe y3b w6 h1a"><div class="t m0 xd h9 y3c ff3 fs5 fc0 sc0 ls0 ws0"> </div>
    </div>
    <div class="c x10 y3b w7 h1a">
        <div class="t m0 x1a h9 y3d ff3 fs5 fc0 sc0 ls5 ws0"><?php echo e($getProfileDetails->first()->probEOBIEmployee + $getProfileDetails->first()->probEOBIEmployer); ?><span class="ls0"> </span>
        </div>
    </div>
        <div class="c x13 y3b w8 h1a">

            <div class="t m0 x1a h9 y3d ff3 fs5 fc0 sc0 ls5 ws0"><?php echo e($getProfileDetails->first()->confirmationEOBIEmployee + $getProfileDetails->first()->confirmationEOBIEmployer); ?><span class="ls0"> </span>
            </div>
        </div>

        <div class="c x1 y1 w2 h0"><div class="t m0 x5 h9 y3e ff3 fs5 fc0 sc0 ls0 ws0">Probation Terms </div><div class="t m0 x5 h9 y3f ff3 fs5 fc0 sc0 ls5 ws0">1.<span class="ff7 ls0"> <span class="_ _7"> </span><span class="ff3">You will be on probation for a period of six months.  </span></span></div><div class="t m0 x5 h9 y40 ff3 fs5 fc0 sc0 ls5 ws0">2.<span class="ff7 ls0"> <span class="_ _7"> </span><span class="ff3">During the probation period, one-week notice will be required from either side for severance of servi<span class="_ _0"></span>ce.  </span></span></div><div class="t m0 x5 h9 y41 ff3 fs5 fc0 sc0 ls5 ws0">3.<span class="ff7 ls0"> <span class="_ _7"> </span><span class="ff3">You <span class="_ _8"></span>would <span class="_ _8"></span>not <span class="_ _2"></span>b<span class="_ _2"></span>e <span class="_ _8"></span>entitled <span class="_ _8"></span>t<span class="_ _0"></span>o <span class="_ _8"></span>any<span class="_ _0"></span> <span class="_ _8"></span>benefit <span class="_ _8"></span>durin<span class="_ _0"></span>g <span class="_ _8"></span>this <span class="_ _8"></span>period. <span class="_ _9"></span>On <span class="_ _9"></span>completion <span class="_ _9"></span>o<span class="_ _2"></span>f <span class="_ _8"></span>this <span class="_ _9"></span>period <span class="_ _9"></span>you<span class="_ _2"></span> <span class="_ _9"></span>wi<span class="_ _9"></span>ll <span class="_ _9"></span>be <span class="_ _8"></span>considered <span class="_ _8"></span>affirmed <span class="_ _9"></span>as <span class="_ _8"></span>a </span></span></div><div class="t m0 x1b h9 y42 ff3 fs5 fc0 sc0 ls0 ws0">confirmed employee unless this period is extended or you have been requested for cessa<span class="_ _0"></span>tion of services. <span class="_ _2"></span> </div><div class="t m0 x1b h9 y43 ff3 fs5 fc0 sc0 ls0 ws0"> </div><div class="t m0 x5 h9 y44 ff3 fs5 fc0 sc0 ls0 ws0">Confirmation Terms </div><div class="t m0 x5 h9 y45 ff3 fs5 fc0 sc0 ls5 ws0">1.<span class="ff7 ls0"> <span class="_ _7"> </span><span class="ff3">PACRA provides a leave pool. Other than Maternity &amp; Paternity, </span></span></div><div class="t m0 x1b h9 y46 ff3 fs5 fc0 sc0 ls0 ws0">all leaves will be from this pool. Leave entitlement is calculated </div><div class="t m0 x1b h9 y47 ff3 fs5 fc0 sc0 ls0 ws0">on proportionate basis.  </div><div class="t m0 x1b h9 y48 ff3 fs5 fc0 sc0 ls0 ws0"> </div><div class="t m0 x5 h9 y49 ff3 fs5 fc0 sc0 ls5 ws0">2.<span class="ff7 ls0"> <span class="_ _7"> </span><span class="ff3">Reimbursement of <span class="_ _2"></span>actual exp<span class="_ _2"></span>enses of ho<span class="_ _2"></span>spitalization, maternity, and major <span class="_ _2"></span>medical<span class="_ _2"></span> care <span class="_ _2"></span>(self an<span class="_ _2"></span>d dep<span class="_ _2"></span>endents) up <span class="_ _2"></span>to annual <span class="_ _2"></span>limits </span></span></div><div class="t m0 x1b h9 y4a ff3 fs5 fc0 sc0 ls0 ws0">is allowed. However, during first year of service, entitlement is esta<span class="_ _0"></span>blished on a proportionate basis.<span class="_ _2"></span> </div><div class="t m0 x5 h9 y4b ff3 fs5 fc0 sc0 ls5 ws0">3.<span class="ff7 ls0"> <span class="_ _7"> </span><span class="ff3">Life insurance cover is provided.<span class="_ _0"></span> This is equivalent to <span class="_ _0"></span>36 Basic Salaries. An employee wo<span class="_ _0"></span>uld become elig<span class="_ _2"></span>ible for this after 3 years </span></span></div><div class="t m0 x1b h9 y4c ff3 fs5 fc0 sc0 ls0 ws0">of service. Up till that period, the cover is capped at PKR 500,000. </div><div class="t m0 x5 h9 y4d ff3 fs5 fc0 sc0 ls5 ws0">4.<span class="ff7 ls0"> <span class="_ _7"> </span><span class="ff4">For severance of service, one month’s notice will apply on either s<span class="_ _0"></span>ide.<span class="ff3"> </span></span></span></div><div class="t m0 x5 h9 y4e ff3 fs5 fc0 sc0 ls5 ws0">5.<span class="ff7 ls0"> <span class="_ _7"> </span><span class="ff4">You will be entitled to other benefits under Company’s HR Policy, if admissible and ex<span class="_ _0"></span>p<span class="_ _2"></span><span class="ff3">licitly communicated. </span></span></span></div><div class="t m0 x5 h9 y4f ff3 fs5 fc0 sc0 ls0 ws0"> </div><div class="t m0 x5 h9 y50 ff3 fs5 fc0 sc0 ls0 ws0">You are ex<span class="_ _0"></span>pected to j<span class="_ _0"></span>oin on <span class="ls6" style="font-weight: bold"><?php echo e(date('d-M-y', strtotime($getProfileDetails->first()->dateJoining ?? ''))); ?></span>, subjec<span class="_ _0"></span>t to satisfa<span class="_ _0"></span>ctory completion of <span class="_ _0"></span>the regulatory <span class="_ _0"></span>requirement. P<span class="_ _0"></span>lease sign the<span class="_ _0"></span> attached co<span class="_ _0"></span>py of thi<span class="_ _0"></span>s </div><div class="t m0 x5 h9 y51 ff3 fs5 fc0 sc0 ls0 ws0">letter in token of your acceptance of this offer. </div><div class="t m0 x1b h9 y52 ff3 fs5 fc0 sc0 ls0 ws0"> </div><div class="t m0 x1b h9 y53 ff3 fs5 fc0 sc0 ls0 ws0"> </div><div class="t m0 x5 h9 y54 ff3 fs5 fc0 sc0 ls0 ws0">Yours truly </div>
        <div class="t m0 x5 h1b y55 ff3 fs7 fc0 sc0 ls0 ws0"> </div>
        <div class="t m0 x1c h1b y56 ff3 fs7 fc0 sc0 ls0 ws0"> </div>
        <div class="t m0 x5 hd y57 ff2 fs7 fc0 sc0 ls0 ws0"> </div>
        <div class="t m0 x5 hd y58 ff2 fs7 fc0 sc0 ls0 ws0">Shahzad Saleem<span class="_ _2"></span> </div><div class="t m0 x5 hd y59 ff2 fs7 fc0 sc0 ls0 ws0">Chief Executive<span class="ff3 fs5"> </span></div><div class="t m0 x5 h2 y5a ff1 fs0 fc0 sc0 ls0 ws0"> </div></div><div class="c x1d y5b wb h17"><div class="t m0 xd ha y33 ff2 fs5 fc0 sc0 ls0 ws0">Time with PACRA </div></div><div class="c x1e y5b wc h17"><div class="t m0 xd ha y33 ff2 fs5 fc0 sc0 ls0 ws0">Leaves Per Month</div></div><div class="c x1d y5c wb h1c"><div class="t m0 xd h9 y5d ff3 fs5 fc0 sc0 ls0 ws0">During 1st Year of Service </div></div><div class="c x1e y5c wc h1c"><div class="t m0 x1f h9 y5d ff3 fs5 fc0 sc0 ls5 ws0">1.5<span class="ls0"> </span></div></div><div class="c x1d y5e wb h1d"><div class="t m0 xd h9 y5f ff3 fs5 fc0 sc0 ls0 ws0">2 Years & onwards </div></div><div class="c x1e y5e wc h1d"><div class="t m0 x1f h9 y5f ff3 fs5 fc0 sc0 ls5 ws0">2<span class="ls0"> </span></div></div></div><div class="pi" data-data='{"ctm":[1.000000,0.000000,0.000000,1.000000,0.000000,0.000000]}'></div></div>
</div>
<div class="loading-indicator">

</div>
</body>
</html>
<?php /**PATH E:\pacra-hrms\resources\views/appointmentLetter.blade.php ENDPATH**/ ?>