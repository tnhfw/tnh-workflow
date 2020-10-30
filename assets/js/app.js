
$(document).ready(function() {
  var body = $('body');

    body.tooltip({
        selector: '[data-toggle="tooltip"]'
    });
    body.popover({
        selector: '[data-toggle="popover"]'
    });

    $('.sidebar-toggle').on('click', function (e) {
        e.preventDefault();
        $('.sidebar').toggleClass('toggled');
    });

    ///////////////// mermaid //////////////////////////////
    var config = {
      startOnLoad:true,
      flowchart:{
        useMaxWidth:true,
        htmlLabels:true,
        curve:'cardinal',
      },
      securityLevel:'loose',
      theme: 'forest'
    };
    mermaid.initialize(config);

    /////////////////////////////////////////////////////////
    

    $("#wf_add_actor_row").click(function(e){
      e.preventDefault();
      var frow = "<tr class = 'wf_actor_new_row'>"+$("#wf_actor_first_row").html()+"</tr>";
      $("#wf_actor_tbody").append(frow);
    });
});
