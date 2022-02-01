function selectsLeader(){  
    var ele=document.getElementsByName('check_list_leader[]');  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=true;  
    }  
}  
function deSelectLeader(){  
    var ele=document.getElementsByName('check_list_leader[]');  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=false;  
          
    }  
}  

function selectsLeaders(){  //same method that selects leaders but for the change leader part
    var ele=document.getElementsByName('check_list_leaders[]');  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=true;  
    }  
}  
function deSelectLeaders(){  //same method that deselects leaders but for the change leader part
    var ele=document.getElementsByName('check_list_leaders[]');  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=false;  
          
    }  
}  

function selectsMember(){  
    var ele=document.getElementsByName('check_list_member[]');  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=true;  
    }  
}  
function deSelectMember(){  
    var ele=document.getElementsByName('check_list_member[]');  
    for(var i=0; i<ele.length; i++){  
        if(ele[i].type=='checkbox')  
            ele[i].checked=false;  
          
    }  
}  