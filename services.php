<?php
require 'includes/header.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="styles/normalize.css">
<link rel="stylesheet" href="styles/styles.css">
<title>Services</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script> 
$(function(){
    $('#category-tabs li a').click(function(){
    $(this).next('ul').slideToggle('500');
    $(this).find('i').toggleClass('fa-plus-circle fa-minus-circle');
});
  });
</script>
</head>
<main id='mainservices'>
    <section class='services'>
        <section class='subservices'>
            <h3><span>Grooming</span></h3>
                <img src="images/dog-groom-380-300.png" alt="dog grooming">
                <p>As fun and convenient as our self service wash is, we know that do-it-yourself pet grooming is not always on your list of Top 10 favorite ways to spend your free time! That's why Sandy's Grooming offers full service, professional grooming in Seattle. Even if you do enjoy bathing your pup, everyone deserves a spa day once in a while! Our professional pet grooming service is a great way to spoil a pet that has been an extra good boy.
                Unlike other grooming "production" shops, Sandys Grooming  limit the number of clients they see each day so that they can spend quality one-on-one time with each dog. Our dog grooming professionals will lather, wash, and pamper your pet. You can expect a shiny, soft coat, clipped nails, and a sweet smell! Most pets are finished and ready to go home in about three hours, instead of spending the whole day at the shop. You can drop your pet off, do your shopping, run some errands, and come back for pick up.Schedule your professional pet grooming service today. Walk-ins welcome for all self-wash stations! </p>
                <button class='book-btn'><a href="grooming.php">Book Now</a></button>
                <ul id="category-tabs">
                    <li><a href="javascript:void"><i class="fa fa-plus-circle"></i>Click to View Grooming Rates and Details</a>
                        <ul class='rates-ul'>
                            <li><a href="javascript:void">30 Minute Grooming. Depending on your pet’s specific needs – $15.00 per visit (3 or more visits per week required)</a></li>
                            <li><a href="javascript:void">45 Minute Grooming, Depending on your pet’s specific needs –  $17/visit single visits</a></li>
                            <li><a href="javascript:void">60 Minute Grooming, needs to be scheduled at least 24 hours before the day of visit. Depending on your pet’s specific needs – $25.00 per visit </a></li>
                        </ul>
                    </li>
                </ul>
            </section>

        <section class='subservices'>
                <h3><span>Self Washing</span></h3>
                <img src='images/self-wash-380x380.png' alt = "dog-washing">
                <h4>Basic Wash</h4>
                <p>Basic Wash Includes an apron, brushes & combs, house shampoo, cream rinse, towels and dryer.
                This is content other Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, voluptatem? Corporis, tempora distinctio beatae cumque placeat officiis alias officia dolorum ducimus adipisci sunt quam architecto tenetur. Similique quo quos dignissimos!locale_get_region</p>
                <button class='book-btn'><a href="grooming.php">Book Now</a></button>
                <ul id="category-tabs">
                    <li><a href="javascript:void"><i class="fa fa-plus-circle"></i>Click to View Grooming Rates and Details</a>
                        <ul class='rates-ul'>
                            <li><a href="javascript:void">30 Minute Basic self wash. Depending on your pet’s specific needs – $25.00 per visit (3 or more visits per week required)</a></li>
                            <li><a href="javascript:void">45 Minute Basic self wash, Depending on your pet’s specific needs –  $30/visit single visits</a></li>
                            <li><a href="javascript:void">60 Minute Basic self wash, needs to be scheduled at least 24 hours before the day of visit. Depending on your pet’s specific needs – $35.00 per visit </a></li>
                        </ul>
                    </li>
                </ul> 
          
                <h4>Premium Wash</h4>
                <p>Includes your choice of premium shampoos, cream rinse, leave-in coat shiner & skin moisturizer, cologne, apron, brushes & combs, towels & dryer.Premium Wash </p>
                <button class='book-btn'><a href="grooming.php">Book Now</a></button>
                <ul id="category-tabs">
                    <li><a href="javascript:void"><i class="fa fa-plus-circle"></i>Click to View Grooming Rates and Details</a>
                        <ul class='rates-ul'>
                            <li><a href="javascript:void">30 Minute Premier self wash. – $18.00 per visit</a></li>
                            <li><a href="javascript:void">45 Minute Premier self wash. –  $20/visit single visits</a></li>
                            <li><a href="javascript:void">60 Minute Premier self wash.  – $28.00 per visit </a></li>
                        </ul>
                    </li>
                </ul>

                <h4>Ultimate Wash</h4>
                <div class='service-para-wrapper'><p>Includes shampoo, conditioner, leave-in coat shiner & skin moisturizer, cologne, apron, brushes & combs, towels & dryer.quam architecto tenetur. Similique quo quos dignissimos!locale_get_region</p></div>
                <button class='book-btn'><a href="grooming.php">Book Now</a></button>
                <ul id="category-tabs">
                    <li><a href="javascript:void"><i class="fa fa-plus-circle"></i>Click to View Grooming Rates and Details</a>
                        <ul class='rates-ul'>
                            <li><a href="javascript:void">30 Ultimate Wash.(coconut oil shampoo and tea tree conditioner is provided)  – $25.00 per visit (3 or more visits per week required)</a></li>
                            <li><a href="javascript:void">45 Ultimate Wash,(coconut oil shampoo and tea tree conditioner is provided)  –  $35/visit single visits</a></li>
                            <li><a href="javascript:void">60 Ultimate Wash,(coconut oil shampoo and tea tree conditioner is provided)  – $40.00 per visit </a></li>
                        </ul>
                    </li>
                </ul> 
       
                <img src="images/fur-buster.png" alt="dogs in tub being washed">
                <h4>Fur Buster</h4>
                <p>Our specially formulated anti-shed shampoo and rejuvenating conditioner that will tighten pores and moisturize dry skin to help reduce shedding..  </p>
                <button class='book-btn'><a href="grooming.php">Book Now</a></button>
                <ul id="category-tabs">
                    <li><a href="javascript:void"><i class="fa fa-plus-circle"></i>Click to View Grooming Rates and Details</a>
                        <ul class='rates-ul'>
                            <li><a href="javascript:void">30 Minute Ultimate Wash and after shower towel drying or hot fan drying service with massage. – $35.00 per visit (3 or more visits per week required)</a></li>
                            <li><a href="javascript:void">45 Minute Ultimate Wash and after shower towel drying or hot fan drying service with massage, –  $47/visit single visits</a></li>
                            <li><a href="javascript:void">60 Minute Ultimate Wash and after shower towel drying or hot fan drying service with massage, – $55.00 per visit </a></li>
                        </ul>
                    </li>
                </ul>
        </section>

        <section class='subservices'>
                <h3><span>Nail Trimming</span></h3>
                <img src="images/cat-paw-380x380.png" alt="nail trimming">
                <p>Nail Trim - Regular and Nail Trim with Dremel Machine. Grinding smooths out rough edges on your dog's nails to reduce scratches while keeping nails shorter for longer. Prevents painful splaying & splitting of your dog's nails. No appointment needed!</p>
                <button class='book-btn'><a href="grooming.php">Book Now</a></button>
                <ul id="category-tabs">
                    <li><a href="javascript:void"><i class="fa fa-plus-circle"></i>Click to View Grooming Rates and Details</a>
                        <ul class='rates-ul'>
                            <li><a href="javascript:void">30 Minute Regular Nail trimming. Prevents painful splaying & splitting of your dog's nails. No appointment needed! - $28 per visit</a></li>
                            <li><a href="javascript:void">45 Minute Dremel Grinding Nail Trimming, Grinding smooths out rough edges on your dog's nails to reduce scratches while keeping nails shorter for longer. No appointment needed! $38.00 per visit.</a></li>
                        </ul>
                    </li>
                </ul> 
        </section>
    </section>
</main>
<?php
require 'includes/footer.php';
?>