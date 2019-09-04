'use strict';

(function($){

  $(function() {

    /*var datascource = {
      'id': '1',
      'name': 'Lao Lao',
      'title': 'general manager',
      'relationship': '001',
      'children': [
        { 'id': '2', 'name': 'Bo Miao', 'title': 'department manager', 'relationship': '110' },
        { 'id': '3', 'name': 'Su Miao', 'title': 'department manager', 'relationship': '111',
          'children': [
            { 'id': '4', 'name': 'Tie Hua', 'title': 'senior engineer', 'relationship': '110' },
            { 'id': '5', 'name': 'Hei Hei', 'title': 'senior engineer', 'relationship': '111',
              'children': [
                { 'id': '6', 'name': 'Pang Pang', 'title': 'engineer', 'relationship': '110' },
                { 'id': '7', 'name': 'Xiang Xiang', 'title': 'UE engineer', 'relationship': '110' }
              ]
            }
          ]
        },
        { 'id': '8', 'name': 'Yu Jie', 'title': 'department manager', 'relationship': '110' },
        { 'id': '9', 'name': 'Yu Li', 'title': 'department manager', 'relationship': '110' },
        { 'id': '10', 'name': 'Hong Miao', 'title': 'department manager', 'relationship': '110' },
        { 'id': '11', 'name': 'Yu Wei', 'title': 'department manager', 'relationship': '110' },
        { 'id': '12', 'name': 'Chun Miao', 'title': 'department manager', 'relationship': '110' },
        { 'id': '13', 'name': 'Yu Tie', 'title': 'department manager', 'relationship': '110' }
      ]
    };
    */
    
    var datascource = {
      'id': '1', 'name': 'RP Sambodo Sru Ujianto / Bpk/Ibu Handojo, Bpk Adi/Ibu Agnes Surya', 'title': 'Moderator / Penasehat', 'relationship': '001', 'cnt': 5, 'picId': '1|1|1|1|1', //mandatory
      'children': [
        { 'id': '2', 'name': 'Henry Kwee', 'title': 'Ketua Umum', 'relationship': '101', 'cnt': 1, 'picId': '1',
          'children': [
            { 'id': '3', 'name': 'Wahendro', 'title': 'Wakil Ketua Umum', 'relationship': '111', 'cnt': 1, 'picId': '1',
              'children': [
              { 'id': '4', 'name': 'A', 'title': 'Bendahara 1', 'relationship': '110', 'cnt': 1, 'picId': '1' },
              { 'id': '5', 'name': 'B', 'title': 'Sekretaris 1', 'relationship': '110', 'cnt': 1, 'picId': '1' },
              { 'id': '6', 'name': 'C', 'title': 'Bendahara 2', 'relationship': '110', 'cnt': 1, 'picId': '1' },
              { 'id': '7', 'name': 'D', 'title': 'Sekretaris 2', 'relationship': '110', 'cnt': 1, 'picId': '1' }
              ]
            },
            { 'id': '8', 'name': 'E', 'title': 'Unit1', 'relationship': '101', 'cnt': 1, 'picId': '1' },
            { 'id': '8', 'name': 'F', 'title': 'Unit1', 'relationship': '101', 'cnt': 1, 'picId': '1' },
            { 'id': '8', 'name': 'G', 'title': 'Unit1', 'relationship': '101', 'cnt': 1, 'picId': '1' } 
          ]
        }
      ]
    };

    $('#chart-container').orgchart({
      'data' : datascource,
      'depth': 5,
      'nodeTitle': 'name',
      'nodeContent': 'title',
      'nodeID': 'id',
      'createNode': function($node, data) {
        var secondMenuIcon = $('<i>', {
          'class': 'fa fa-info-circle second-menu-icon',
          click: function() {
            $(this).siblings('.second-menu').toggle();
          }
        });
        var avatar="";
        var spltPicId = data.picId.split('|');
        for(var x=0;x<data.cnt;x++){
          avatar += '<img class="avatar" src="../img/avatar/' + spltPicId[x] + '.jpg">';
        }
        //var secondMenu = '<div class="second-menu"><img class="avatar" src="../img/avatar/' + data.id + '.jpg"></div>';
        var secondMenu = '<div class="second-menu">'+ avatar +'</div>';
        $node.append(secondMenuIcon).append(secondMenu);
      }
    });

  });

})(jQuery);