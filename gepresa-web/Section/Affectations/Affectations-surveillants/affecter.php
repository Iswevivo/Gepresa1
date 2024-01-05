<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
td,th{
   border:1px solid black;
     }
     th{
       background-color:#182a52;
       color:white;
       font-weight: normal;
       font-size:20px;
     }
        table{
           border-collapse:collapse;
           margin-left:30%;
           width:40%;
           top:30%;
           width:50%
        }
        .page1{
          text-align: center;
        }
        .text-tarif{
            text-align:center;
        }
        .membre{
          font-size:18px;
        }
   </style>
<body>
    <h1>Tableau</h1>
      <table>
          <tr>
            <th>
                N°
            </th>
            <th>
            Date surveillance
            </th>
            <th>
            Salles
            </th>
            <th>
            Vacation
            </th>
            <th>
            Nom des surveillants
            </th>
          </tr>
          <?php
            $bdd=new PDO('mysql:host=localhost;dbname=gepresa;', 'root' ,'');
            //  recuperation des element de la table surveiller
                $recuperer_article1=$bdd->query('SELECT *FROM surveiller ORDER BY id DESC');
                //  recuperation des element de la table s
                $recuperer_article2=$bdd->query('SELECT *FROM salles ORDER BY id DESC');
                $recuperer_article3=$bdd->query('SELECT *FROM surveillants ORDER BY id DESC');
                $i=1;
                while($surveiller=$recuperer_article1->fetch()){
                     while($salles=$recuperer_article2->fetch()){
                         
                           
                            ?>
                            <tr>
                                <td class="numero"><?php
                                  echo $i;
                                   
                                 ?>
                               </td>
                               <td class=""> <?=$surveiller['dateSurveillance'];?></td>
                                <td class=""> <?=$salles['nomSalle'];?> </td> 
                                <td class=""> <?=$surveiller['vacation'];?></td>
                                
                                
                                 <td>
                                 <?php
                                  
                                 while($surveillant=$recuperer_article3->fetch()){
                                     $sallenom=$salles['nomSalle'];
                                     $sallenom2=$surveillant['salle'];
                                     $nomsurveillant=$surveillant['nomComplet'];
                                    
                                      echo $nomsurveillant.'<br>';
                                    
                                       
                                        
                                      
                                    }
                                 ?>
                                 </td>
                               </tr>
                    <?php
                       $i++;  
                     }
                 
                }
                
            ?>
      </table>
     
</body>
</html>