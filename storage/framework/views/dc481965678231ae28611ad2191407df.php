<?php
	$sectionOptions = $getStatsOp ?? [];
	$sectionData ??= [];
	$stats = (array)data_get($sectionData, 'count');
	
	$iconPosts = $sectionOptions['icon_count_listings'] ?? 'fas fa-bullhorn';
	$iconUsers = $sectionOptions['icon_count_users'] ?? 'fas fa-users';
	$iconLocations = $sectionOptions['icon_count_locations'] ?? 'far fa-map';
	$prefixPosts = $sectionOptions['prefix_count_listings'] ?? '';
	$suffixPosts = $sectionOptions['suffix_count_listings'] ?? '';
	$prefixUsers = $sectionOptions['prefix_count_users'] ?? '';
	$suffixUsers = $sectionOptions['suffix_count_users'] ?? '';
	$prefixLocations = $sectionOptions['prefix_count_locations'] ?? '';
	$suffixLocations = $sectionOptions['suffix_count_locations'] ?? '';
	$disableCounterUp = $sectionOptions['disable_counter_up'] ?? false;
	$counterUpDelay = $sectionOptions['counter_up_delay'] ?? 10;
	$counterUpTime = $sectionOptions['counter_up_time'] ?? 2000;
	$hideOnMobile = (data_get($sectionOptions, 'hide_on_mobile') == '1') ? ' hidden-sm' : '';
?>

<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="call-to-action text-white text-center" id="foo" style="background-color: #fff;">
     
    <style>

.container123 {
    display: flex;
    background-color: #fff;
    border-radius: 10px;
/*    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);*/
    max-width: 1000px;
/*    overflow: hidden;*/
     margin-left: 5%;
     margin-right: 5%;
}

          
.notice-board {
/*    width: 75%;*/
    padding: 5px;
/*    border-right: 1px solid #ddd;*/
}

.notice-board h1 {
    color: #33a532;
    margin-top: 10px;
    margin-bottom: 15px;
    font-size: 33px;
}
        
.greenfont{
    color: #33a532;
}

.notice-card {
    display: flex;
    align-items: center;
    gap: 15px;
}

.notice-image {
    width: 200px;
    border-radius: 5px;
    object-fit: contain;
    padding-bottom: 30px;
}

.notice-content h2 {
    font-size: 18px;
    color: #333;
    text-align: left;
}

.time-info {
    font-size: 16px;
    color: gray;
    margin-top: 5px;
    text-align: left;
}

.category {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

.advertise-btn {
    background-color: #fcb546;
    color: white;
    margin-right: 40px;
    border: none;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
     cursor: pointer; 
    font-weight: bold;
    float: right;
    font-size: 13px;
}

.advertise-btn:hover {
    background-color: #ffa500;
}

/* Ad section styles */
.ad-section123 {
/*    width: 25%;*/
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
/*    background-color: #fff7e6;*/
   
}

.ad-content123 {
    text-align: center;
}

.ad-icon123 {
    font-size: 40px;
    margin-bottom: 10px;
    background-image: url('https://buyme.lk/public/images/search_ad.png');
    background-size: cover; /* Ensure the image covers the entire element */
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Prevent repeating the image */
    width: 70px; /* Set width for the element */
    height: 70px; /* Set height for the element */
}

.ad-content123 h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #333;
}

.ad-content123 p {
    font-size: 10px;
    color: #555;
    line-height: 1.6;
}

.ad-content123 a {
    color: #007bff;
    text-decoration: none;
}

.ad-content123 a:hover {
    text-decoration: underline;
}
        
.ad-icon-container {
/*    text-align: center;*/
}

/* Circle background */
.ad-circle {
    width: 120px;
    height: 120px;
    background-color: #fcb546;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
/*    position: relative;*/
    margin-bottom: 10px;
}

/* Megaphone structure */
.megaphone {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Handle of the megaphone */
.handle {
    width: 10px;
    height: 25px;
    background-color: black;
    border-radius: 2px;
}

/* Cone of the megaphone */
.cone {
    width: 50px;
    height: 30px;
    background-color: white;
    clip-path: polygon(0 0, 100% 30%, 100% 70%, 0 100%);
    position: relative;
}

/* 'AD' text inside the cone */
.ad-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    font-weight: bold;
    color: #007bff;
}

/* Caption under the icon */
.ad-text-caption {
    font-size: 14px;
    color: #333;
    margin-top: 5px;
}
.sup-ad {
            background: #8B8B8B;
            color: #000000;
            font-size: 13pt;

    
}
.sup-advert{
            background:  ;
            color: #128305;
            font-size: 13pt;
            text-align: center;
} 

.rainbow {
/*
  width: 400px;
  height: 300px;
*/
  border-radius: 10px;
/*  padding: 2rem;*/
  margin: auto;

  display: grid;
  place-content: center;
  text-align: center;

  font-size: 1.5em;

  --border-size: 0.6rem;
  border: var(--border-size) dotted transparent;
        
/*  background: linear-gradient(60deg, green, orange, green, orange, green, orange, green, orange);*/
        
        
  background-image: linear-gradient(
      to right,
      rgb(255 255 255 / var(--opacity)),
      rgb(255 255 255 / var(--opacity))
    ),
    conic-gradient(
      from var(--angle),
      green 0deg 45deg,
      orange 45deg 90deg,
      green 90deg 135deg,
      orange 135deg 180deg,
      green 180deg 225deg,
      orange 225deg 270deg,
      green 270deg 315deg,
      orange 315deg 360deg
    );
  background-origin: border-box;
  background-clip: padding-box, border-box;
}

@property --opacity {
  syntax: "<number>";
  initial-value: 1.0;
  inherits: false;
}

@property --angle {
  syntax: "<angle>";
  initial-value: 0deg;
  inherits: false;
}

@keyframes opacityChange {
  to {
    --opacity: 100;
  }
}

@keyframes rotate {
  to {
    --angle: 360deg;
  }
}

.rainbow {
  animation: rotate 4s linear infinite;
}

@media (max-width: 768px) {
	.notice-card {
	 display: inline-block;
	}
    .notice-content h2 {
        font-size: 14px; /* Decrease the font size for smaller screens */
    }
    
    .notice-board h1 {
        font-size: 28px; /* Adjust heading size for mobile screens */
    }
    
    .time-info {
    font-size: 14px;
 
   }
 
}

    
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
    <center>
    <div class="container123 row">
        <div  class="rainbow col-xl-8 col-md-12 col-sm-12">
            <div class="notice-board">
                <h1>BuyMe Wanted Notice Board</h1>
                <div id="wanted-card" class="notice-card">
                    <a href="posts/create/?wanted=1">
                    <div><img src="public/images/wanted_thumbnail.png" alt="BuyMe wanted ad notice board" class="notice-image"></div>
                    </a>
                    <div class="notice-content">
                        <a href="posts/create/?wanted=1">
                        <h2><b>BuyMe Wanted Advertisements</b></h2>
                        <p class="time-info"><i class="fas fa-clock"></i> 1 hour ago <br><i class="fas fa-folder"></i> <font class="greenfont">Category</font> / <font class="greenfont">Subcategory</font> <br><i class="fas fa-map-marker"></i> <font class="greenfont">Location</font></p></a><br><br>     
                    </div>   
                </div>
                <!-- <a href="posts/create">
                <span class="advertise-btn">Advertise now</span>
                 </a> -->
            </div>
        </div>
        

        <div class="ad-section123 col-xl-4 col-md-12 col-sm-12">
            <div class="ad-content123">
                <center>
                <div class="ad-icon-container">
        <div class="ad-circle">
            <div class="ad-icon123">
                 
                <sup class="sup-ad"> </sup></div>
        </div>
    </div>
                    
                <h3><b><?php echo e(t('did_not_find')); ?></b></h3>
                <h4 class="sup-advert">
                    <?php echo e(t('increase_chances')); ?>

               </h4>
                     <a href="posts/create/?wanted=1">
               
                <span class="btn btn-block btn-border btn-listing"><?php echo e(t('click_to_advertise')); ?></span>
                <BR>
                    <BR>
                 </a>
               
                </center>
            </div>
        </div>


    </div>
</center>
</section>

<!-- <section class="showcase">
    <div class="container-fluid p-0">
      <div class="d-flex no-gutters">
        <div class="col-lg-6 order-lg-2 text-white showcase-img"  ></div>
        <div class="col-lg-6 order-lg-1 showcase-text">
		  <h1 class="mb-2" style="font-weight: bold;">Why Choose Us?</h1>
          <p class="mb-1">Embark on your selling journey with BUYME.LK in just a few simple steps. Create your seller account to unlock a world of opportunities, list your properties and vehicles effortlessly, and engage with potential buyers. Join us in making selling as easy as 1-2-3. Ready to get started? Create your seller account now and witness the buyme.lk advantage firsthand!</p>
        </div>
      </div>
      </div>
    </div>
</section> -->

<!-- <div class="container<?php echo e($hideOnMobile); ?>">
	<div class="page-info page-info-lite rounded">
		<div class="text-center section-promo">
			<div class="row">
				
				<div class="col-sm-4 col-12">
					<div class="iconbox-wrap">
						<div class="iconbox">
							<div class="iconbox-wrap-icon">
								<i class="<?php echo e($iconPosts); ?>"></i>
							</div>
							<div class="iconbox-wrap-content">
								<h5>
									<?php if(!empty($prefixPosts)): ?><span><?php echo e($prefixPosts); ?></span><?php endif; ?>
									<span class="counter"><?php echo e((int)data_get($stats, 'posts')); ?></span>
									<?php if(!empty($suffixPosts)): ?><span><?php echo e($suffixPosts); ?></span><?php endif; ?>
								</h5>
								<div class="iconbox-wrap-text"><?php echo e(t('classified_ads')); ?></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-sm-4 col-12">
					<div class="iconbox-wrap">
						<div class="iconbox">
							<div class="iconbox-wrap-icon">
								<i class="<?php echo e($iconUsers); ?>"></i>
							</div>
							<div class="iconbox-wrap-content">
								<h5>
									<?php if(!empty($prefixUsers)): ?><span><?php echo e($prefixUsers); ?></span><?php endif; ?>
									<span class="counter"><?php echo e((int)data_get($stats, 'users')); ?></span>
									<?php if(!empty($suffixUsers)): ?><span><?php echo e($suffixUsers); ?></span><?php endif; ?>
								</h5>
								<div class="iconbox-wrap-text"><?php echo e(t('Trusted Sellers')); ?></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-sm-4 col-12">
					<div class="iconbox-wrap">
						<div class="iconbox">
							<div class="iconbox-wrap-icon">
								<i class="<?php echo e($iconLocations); ?>"></i>
							</div>
							<div class="iconbox-wrap-content">
								<h5>
									<?php if(!empty($prefixLocations)): ?><span><?php echo e($prefixLocations); ?></span><?php endif; ?>
									<span class="counter"><?php echo e((int)data_get($stats, 'locations')); ?></span>
									<?php if(!empty($suffixLocations)): ?><span><?php echo e($suffixLocations); ?></span><?php endif; ?>
								</h5>
								<div class="iconbox-wrap-text"><?php echo e(t('locations')); ?></div>
							</div>
						</div>
					</div>
				</div>
	
			</div>
		</div>
	</div>
</div> -->





<script> 
    var iii = 0;
    
    setTimeout(function(){
        $.ajax({
               type:'GET',
               url:'wantedads/'+iii,
               success:function(data) {
                   if(data==0)
                   {
                        iii = 0;
                        $.ajax({
                        type:'GET',
                        url:'wantedads/'+iii,
                        success:function(data) {
                            if(data!=0)
                            {
//                                alert(data);
                                document.getElementById('wanted-card').innerHTML=data;
                                iii++;
                            }
                            }
                        });   
                   }
                   else
                   {
//                       alert(data);
                       document.getElementById('wanted-card').innerHTML=data;
                       iii++; 
                   }
                  
               }
            });
    }, 500);
    
     
    {
        setInterval(function(){
            $.ajax({
               type:'GET',
               url:'wantedads/'+iii,
               success:function(data) {
                   if(data==0)
                   {
                        iii = 0;
                        $.ajax({
                        type:'GET',
                        url:'wantedads/'+iii,
                        success:function(data) {
                            if(data!=0)
                            {
//                                alert(data);
                                document.getElementById('wanted-card').innerHTML=data;
                                iii++;
                            }
                            }
                        });   
                   }
                   else
                   {
//                       alert(data);
                       document.getElementById('wanted-card').innerHTML=data;
                       iii++; 
                   }
                  
               }
            });
        }, 10000);
    }
	 </script>

<?php $__env->startSection('after_scripts'); ?>
	<?php echo \Illuminate\View\Factory::parentPlaceholder('after_scripts'); ?>
	<?php if(!isset($disableCounterUp) || !$disableCounterUp): ?>
		<script>
			//const counterUp = window.counterUp.default;
		//	const counterEl = document.querySelector('.counter');
		//	counterUp(counterEl, {
		//		duration: <?php echo e($counterUpTime); ?>,
		//		delay: <?php echo e($counterUpDelay); ?>

		//	});
		</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/home/inc/stats.blade.php ENDPATH**/ ?>