

</div>



<div id="prefooterwrap" class="clear">



    <!-- <div id="prefooter" class="container">

    

    	<section class="slide-up-boxes">



			<a href="/site/about" >

				<h5>Who We Are</h5>

				<div >We Are A Solar Energy Installation Company!</div>				

			</a>

            

				

			<a href="#" >

				<h5>Who We Do It For</h5>

				<div >We Work for Governments, Municipalities, and Corporations.</div>				

			</a>

            

			

			<a href="/site/getstarted" >

				<h5>Get Started Now</h5>

				<div >We Strive to Bring the Benefits of Solar Power to Everyone Saving Resources and Money!</div>				

			</a>

            



		</section>

    

    </div> -->



</div>

<div id="footwrap" class="clear">

	<div id="" class="container clear"></div>

    

    <div id="footer" class="container clear">

        <p>&copy; 2011 Open Sky Media, LLC |

            <a href="http://openskymedia.com">Website Design</a> by

            <a href="http://openskymedia.com">Open Sky Media, LLC</a> |

            <a style="color:#FFF;" href="/sitemap.xml">Sitemap</a> |



            <?php



            if ($this->agent->is_browser()) {

                $agent = $this->agent->browser() . ' ' . $this->agent->version() . ' | ';

            }

            elseif ($this->agent->is_robot())

            {

                $agent = $this->agent->robot();

            }

            elseif ($this->agent->is_mobile())

            {

                $agent = $this->agent->mobile();

            }

            else

            {

                $agent = 'Unidentified User Agent';

            }



            echo $agent;



            echo $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)



            ?>

        </p>

        <p>&nbsp;</p>





    </div><!-- End Footer -->

</div>

</div><!-- End Container -->



  <!-- Google Analytics -->

  

<script type="text/javascript">



  var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'UA-136438-72']);

  _gaq.push(['_setDomainName', 'none']);

  _gaq.push(['_setAllowLinker', true]);

  _gaq.push(['_trackPageview']);



  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();



</script>



<!-- End Google Analytics -->

