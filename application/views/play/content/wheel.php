<div class="container-wheel <?=empty($user) ? 'lock' : '' ?>">
    <div class="the_wheel">
        <canvas id="canvas" width="732" height="732"></canvas>

        <div class="power_controls">
            <div  class="circle-btn" >
                <div id="spin_button"  data-spin='<?=json_encode($awards)?>' num-data="<?=$num_awards?>" ></div>
                <img class='arrow-award' src="<?=ASSETS.'images/arrow-award.png'?>" alt="">
            </div>
        
        </div>
    </div>
</div>

