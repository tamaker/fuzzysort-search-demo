

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
    <script src="https://rawgit.com/farzher/fuzzysort/master/fuzzysort.js"></script>
    

    <style>
        #inner ul { list-style-type: none; }
        .charImages { border: 1px solid black; border-radius: 50%; width: 80px; height: 80px; }
        .item-text { 
            min-height: 100px;
            display: inline-flex;
            align-items: center;
            border: 0px solid black;
        }
    </style>

    <script>
        $(document).ready(function(){
        
            var list= [];
            // THE ARRAY OUR SEARCHABLE CONTENT WILL BE PUSHED TO
            //$.getJSON( 'https://cdn.jsdelivr.net/gh/tamaker/fuzzysort-search-demo@master/data.js', function( data ) {
            $.getJSON( './data.js', function( data ) {
                //console.log(data); //json output 

                $(data[0].characters).each(function (i, val) {
                    //console.log(val)
                    //$(this).attr("id", "item-" + i);
                    var houseName = '';
                    if (val.houseName){
                        houseName = val.houseName + ' - ';
                    }
                    newObj = { itemNum: i, itemText: (houseName +  val.characterName), itemPic: val.characterImageThumb  };
                    list.push(newObj);

                    
                    if (val.characterImageThumb){
                            $('#inner ul').append('<li class="item-' + i + '"><span class="item-text">' + val.characterName + ' [ House: ' + val.houseName + ']</span></li>');
                            $('.item-' + i).prepend('<img class="charImages" src="' + val.characterImageThumb + '">')
                    }
                    
                });

                

            });
            
            //console.log(list);

            // ITERATE THROUGH ALL THE P ELEMENTS AND PUSH THE JSON OBJECT
            //WITH CONTENT AND IDX NUMBER TO THE ARRAY
            


            





            function doSearch(searchVal) {
                $('li').css('display', 'none')
                console.log('doing search');

                
                
                let objects = list;
                let results = fuzzysort.go(searchVal, list, {
                    keys: ['itemText'],
                    limit: 100, // don't return more results than you need!
                    allowTypo: false, // if you don't care about allowing typos
                    threshold: -10000, // don't return bad results,
                    separateWordSearch: false
                        
                });

                var bestResult = results[0];
                console.log(results);
                highlight(searchVal);
                

                if (results.length){
                    $(results).each(function(i, val){
                        //console.log('show item #' + val.obj.itemNum);
                        //console.log(val.obj);
                        //console.log('--------------------------')

                            if (val.obj.itemNum){
                                    $('li.item-'+(val.obj.itemNum).toString()).show();
                                    console.log('li.item-' + val.obj.itemNum)
                            }
                            
                    })

                } else {

                    $('li').show()

                }
                


            }



            function highlight(searchVal){
                $('span.item-text').each(function(i, val){
                        $(this).mark(searchVal);
                })
            }



            // WAIT FOR INPUT TO STOP BEFORE RUNNING THE SEARCH
            var timer = null;
            $("#inputField").keydown(function () {
                clearTimeout(timer);
                timer = setTimeout(doStuff, 1000);
            });

            function doStuff() {
                $("span.item-text").unmark();
                //$("span.highlight").removeClass("highlight");
                //$('span.highlight').contents().unwrap();
                //alert('do stuff');
                doSearch($("#inputField").val());
            }
        })
    </script>
  </head>
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->




    <div id="wrapper">
      <center>
            <input type="text" id="inputField" style="width: 450px; margin: 40px; margin-bottom: 0px; padding: 20px; font-size: 1.4em; background-color: #EEE; border-radius: .4em; border: 2px solid #CCC;" placeholder="search for..." value=""><br>
            <div class="statusText">
                  Type a search word above, fuse.js is used to find and score matches found in each P element below.
                  <pre></pre>
            </div>
      </center>
      
      
      
      
      <div id="inner">
                      
            <ul>
            </ul>
      </div>
</div>



  </body>
</html>