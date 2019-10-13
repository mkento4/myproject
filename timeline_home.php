<?php
 ?>
 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Timeline</title>

     <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
     <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <style>
       .login_user {
         font-size: 14px;
       }
     </style>
   </head>

   <body>
     <div class="time_line">
     </div>
     <br>
   <form class="mx-auto" style="width: 30rem;">
   <div class="form-group">
   <input name="tl_title" type="text" class="tl_title form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter title">
   </div>
   <div class="form-group">
     <textarea class="form-control tl_content rounded-0" id="exampleFormControlTextarea1" rows="10"></textarea>
   <!-- <input name="tl_content" type="text" class="tl_content form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter content"> -->
   </div>
   <input class="insert_timeline btn btn-primary" type="submit" name="tl_send" value="送信">
   <a href="home.php" class="btn btn-secondary">HOME</a>
   </form>
   </div>
     <script
     src="https://code.jquery.com/jquery-3.4.1.min.js"
     integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
     crossorigin="anonymous"></script>
     <script>
     setInterval(function(){
       fetch_timeline();
     },5000);
     fetch_timeline();

     $(document).on('click','.insert_timeline',function(){
       var tl_content = $('.tl_content').val()
       var tl_title = $('.tl_title').val()
       insert_timeline(tl_title,tl_content);
       $('.tl_title').val('');
       $('.tl_content').val('');
       return false;
     });

         function fetch_timeline(){
           $.ajax({
             url: 'timeline.php',
             method: 'post'
           }).done(function(data){
             $('.time_line').html(data);
           });
         }

         function insert_timeline(tl_title,tl_content){
           $.ajax({
             url: 'insert_timeline.php',
             method: 'post',
             data: {
               tl_title:tl_title,
               tl_content:tl_content
             }
           }).done(function(){
             fetch_timeline();
           })
         }
     </script>
   </body>
 </html>
