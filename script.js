$(document).ready(function () {
    // THE ARRAY OUR SEARCHABLE CONTENT WILL BE PUSHED TO
    //list = [];

    // ITERATE THROUGH ALL THE P ELEMENTS AND PUSH THE JSON OBJECT
    //WITH CONTENT AND IDX NUMBER TO THE ARRAY
    $("#inner p").each(function (i, val) {
          $(this).attr("id", "item-" + i);
          newObj = { paraNum: i, paraText: $(val).text() };
          list.push(newObj);
    });

/*
    $(list).each(function(i, val){
        newObj = { characterNum: i, characterText: $(val).characterName };
        list.push(newObj);
    })
*/

    console.log( list );


    

    
    

    function doSearch(searchVal) {
          console.log('doing search')
          let objects = list;
          let results = fuzzysort.go(searchVal, objects, {
            keys: ['paraText'],
            limit: 100, // don't return more results than you need!
            allowTypo: false, // if you don't care about allowing typos
            threshold: -10000, // don't return bad results,
            separateWordSearch: false
                
          })

          var bestResult = results[0];
          console.log(results);
          highlight(searchVal);
          
          /*
          // When using multiple `keys`, results are different. They're indexable to get each normal result
          fuzzysort.highlight(bestResult[0]) // 'Google <b>Chr</b>ome'
          fuzzysort.highlight(bestResult[1]) // 'Launch <b>Chr</b>ome'
          bestResult.obj.title // 'Google Chrome'
          */
    }
    
    
    
    function highlight(searchVal){
          $('#inner p').each(function(i, val){
                $('#inner p').eq(i).mark(searchVal);
          })
    }



    // WAIT FOR INPUT TO STOP BEFORE RUNNING THE SEARCH
    var timer = null;
    $("#inputField").keydown(function () {
          clearTimeout(timer);
          timer = setTimeout(doStuff, 1000);
    });

    function doStuff() {
          $("#inner p").unmark();
          //$("span.highlight").removeClass("highlight");
          //$('span.highlight').contents().unwrap();
          //alert('do stuff');
          doSearch($("#inputField").val());
    }
});
