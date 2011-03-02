
<div id="column1" class="column span-24" style=" margin-top:20px;">

<h1>Welcome To Trash Can Manager!</h1>
<hr />

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum suscipit purus in orci posuere tincidunt
    fermentum est ultrices. Praesent porta eros vitae velit tempor eget rutrum mauris imperdiet. Nunc in erat
    nec justo porttitor semper. Ut sodales tortor a tellus auctor aliquet. Duis rutrum justo mi. Curabitur
    ligula lectus, porttitor ac pharetra nec, viverra non mi. In at nibh vel dui venenatis elementum. Nam
    eget lorem ante, ac tempus massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla lacus
    metus, laoreet rutrum venenatis ut, varius id nisl. Donec eros quam, euismod gravida aliquam quis,
    dapibus eu urna. Integer a turpis eu lacus pharetra volutpat ac eu sapien.</p>
    
<p>Pellentesque sem erat, pretium eget vulputate at, posuere sit amet nulla. Donec accumsan, nulla non
    sollicitudin pulvinar, orci dolor fermentum justo, vel ultricies quam urna eu erat. Duis tempor,
    ante at aliquam imperdiet, augue mauris sodales diam, sed iaculis nunc purus eget magna. Suspendisse
    pulvinar dictum tincidunt. Fusce aliquet blandit arcu in aliquet. Aliquam consequat felis non
    nulla congue mollis. In eget lorem sed velit elementum rutrum nec non tortor. Curabitur tristique
    molestie pharetra. Etiam tempus tempor purus, fermentum ultricies metus pellentesque non. Maecenas
    sed neque massa, eget sagittis urna. Fusce eget sem nec dui porta auctor. Nulla at sapien quis enim
    dapibus accumsan sed id eros. Nulla a magna ligula, vel convallis mauris. Donec venenatis, est vitae
    lacinia vestibulum, dolor magna volutpat quam, eget tincidunt dolor ipsum faucibus nulla. Integer
    accumsan ante in elit accumsan ornare. Pellentesque id enim diam, ac commodo mauris. Etiam dapibus
    fermentum risus, sed auctor urna sollicitudin at.</p>
  
     <div class="span-24" style="">


         <div class="span-15 prepend-1">
             <!-- START EMBED CODE -->

<p>&nbsp;</p>

<!-- END EMBED CODE -->
         </div>


         <div class="span-7">
             <h3>News</h3>
             <?php if(count($news)) : foreach ($news->result() as $row): ?>
         <p><a href="/site/news/<?=$row->id; ?>"><?=$row->headline ?></a></p>
        <?php endforeach; ?>

    <?php else : ?>
        <p>No News Here!</p>
        <?php endif; ?>

        </div>
     
     </div>
</div>



<br />
<p>&nbsp;</p>

