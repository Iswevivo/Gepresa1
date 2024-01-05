<?php
    function db_connection(){
        //connexion vers la bdd
        $servername ="localhost";
        $DBuser = "root";
        $DBpassword = "";
        $DBname = "gepresa";


        try {
            $db = new PDO("mysql:host=$servername;dbname=$DBname", $DBuser, $DBpassword);
            // set the PDO error mode to exception
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Echec de connexion à la base de données : " . $e->getMessage();
        }
        return $db;
    }

    function getAllSections(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Sections ORDER BY designation");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getSectionById(int $id){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Sections WHERE id=$id");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getAllDepartements(){
        $db = db_connection();

        $query = $db->query("SELECT Departements.id as idDep, Sections.id as idSect, Sections.sigle as sigleSect, Departements.sigle as sigleDep, libelle FROM Departements INNER JOIN Sections ON Sections.id = Departements.section_ID ORDER BY libelle");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getDepartById(int $id){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Departements WHERE id=$id");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getAllPromotions(){
        $db = db_connection();

        $query = $db->query("SELECT Promotions.id as idPromot, Promotions.designation as promotion, Departements.id as idDep, Sections.sigle as sigleSect, Departements.sigle as sigleDep, libelle FROM Promotions INNER JOIN (Departements INNER JOIN Sections ON Sections.id = Departements.section_ID) ON Departements.id = Promotions.departement_ID ORDER BY promotion");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getPromotionById(int $id){
        $db = db_connection();

        $query = $db->query("SELECT  Promotions.id as idPromot, Promotions.designation as promotion, Departements.id as idDep, Sections.sigle as sigleSect, Departements.sigle as sigleDep, libelle FROM Promotions INNER JOIN (Departements INNER JOIN Sections ON Sections.id = Departements.section_ID) ON Departements.id = Promotions.departement_ID WHERE Promotions.id=$id");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getPromotionsBySection(){
        $db = db_connection();
        $section = $_SESSION['username'];

        $query = $db->query("SELECT  Promotions.id as idPromot, Promotions.designation as promotion, Departements.id as idDep, Sections.sigle as sigleSect, Departements.sigle as sigleDep, libelle FROM Promotions INNER JOIN (Departements INNER JOIN Sections ON Sections.id = Departements.section_ID) ON Departements.id = Promotions.departement_ID WHERE Sections.sigle='$section'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getAllStudents(){
        $db = db_connection();

        $query = $db->query("SELECT matricule, cardUID, nom, postnom, prenom, sexe, matricule, photo, Promotions.id as idPromot, Promotions.designation as promotion, Etudiants.id as id, Departements.id as idDep, Sections.id as idSect, Departements.sigle as sigleDep, Sections.sigle as sigleSect FROM Etudiants INNER JOIN (Promotions INNER JOIN (Departements INNER JOIN Sections ON Sections.id = Departements.section_ID) ON Departements.id = Promotions.departement_ID) ON Promotions.id = Etudiants.promotion_ID ORDER BY nom");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getStudentsCount(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Etudiants");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }
    function getSallesCount(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Salles");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }
    function getSallesByCapacite(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Salles WHERE capacite > 100");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }
    function getSurveillantsPresencesCount(){
        $db = db_connection();

        $query = $db->query("SELECT COUNT(surveillantID) as nbre FROM Surveiller WHERE timeIn <> '00:00:00' AND timeOut <> '00:00:00' ");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }
    function getStudentsPresencesCount(){
        $db = db_connection();

        $query = $db->query("SELECT COUNT(etudiant_ID) as nbre FROM Passer");
        $nbre_total = $query->fetch()['nbre'];
        
        
        return $nbre_total;
    }
    function getEvaluationsCount(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Evaluations");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }
    function getEvaluationsByDatePassee(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Evaluations WHERE date_evaluation < CURDATE()");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }
    function getSurveillantsCount(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Surveillants");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }
    function getUsersCount(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Users");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }

    function getUsersByState(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Users WHERE statut = 0");
        $nbre_total = $query->rowCount();
        
        
        return $nbre_total;
    }

    function getStudentsByGender(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Etudiants WHERE sexe= 'F'");
        $nbre_filles = $query->rowCount();
        
        
        return $nbre_filles;
    }
    function getSurveillantsByGender(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Surveillants WHERE sexe= 'F'");
        $nbre_filles = $query->rowCount();
        
        
        return $nbre_filles;
    }
    function getStudentById(int $id){
        $db = db_connection();

        $query = $db->query("SELECT Etudiants.id, matricule, cardUID, nom, postnom, prenom, sexe, matricule, photo, Promotions.id as idPromot, Promotions.designation as promotion, Etudiants.id as id, Departements.id as idDep, Sections.id as idSect, Departements.sigle as sigleDep, Sections.sigle as sigleSect FROM Etudiants INNER JOIN (Promotions INNER JOIN (Departements INNER JOIN Sections ON Sections.id = Departements.section_ID) ON Departements.id = Promotions.departement_ID) ON Promotions.id = Etudiants.promotion_ID WHERE Etudiants.id=$id ORDER BY nom");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getStudentByMatricule(string $matricule){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Etudiants WHERE matricule='$matricule'");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getStudentByCard(string $cardUID){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Etudiants WHERE cardUID='$cardUID'");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getAllSurveillants(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Surveillants ORDER BY nomComplet");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getSurveillantByID(int $id){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Surveillants WHERE id=$id");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getSurveillantByName(string $name){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Surveillants WHERE nomComplet='$name'");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getSurveillantByCard(string $cardUID){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Surveillants WHERE cardID='$cardUID'");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        //die(var_dump($result));
        return $result;
    }
    function getAllJurys(){
        $db = db_connection();

        $query = $db->query("SELECT Jury.promotion_ID as idJ, president, sec1, sec2, membre, Departements.sigle as nomDepart, designation FROM Jury INNER JOIN(Promotions INNER JOIN Departements ON Departements.id = Promotions.departement_ID) ON Promotions.id = Jury.promotion_ID ORDER BY designation");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getJuryByPromotion(int $promotion){
        $db = db_connection();

        $query = $db->query("SELECT Jury.promotion_ID as idJ, president, sec1, sec2, membre, Departements.sigle as libelle, designation FROM Jury INNER JOIN(Promotions INNER JOIN Departements ON Departements.id = Promotions.id) ON Promotions.departement_ID = Jury.promotion_ID WHERE Jury.promotion_ID = $promotion");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getAllSalles(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Salles ORDER BY nomSalle");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getSalleByName(string $name){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Salles WHERE nomSalle= '$name'");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getAllUsers(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Users WHERE role <> 'SUPER ADMIN' ORDER BY login");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getUserById(int $id){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Users WHERE id=$id");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getUserByLogin(string $login){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Users WHERE login='$login'");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getSalleById(int $id){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Salles WHERE id= $id");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getAllEvaluations(){
        $db = db_connection();

        $query = $db->query("SELECT Evaluations.id as idEval, promotion_ID, designation, session, intitule_cours, date_evaluation, vacation FROM Evaluations INNER JOIN typeEvaluation ON typeEvaluation.id = Evaluations.type_ID ORDER BY date_evaluation");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getEvaluationsByUsertype(){
        $db = db_connection();

        $id = $_SESSION['id'];

        if($_SESSION['type'] == 'Section'){
            $query = $db->query("SELECT Evaluations.id as idEval, promotion_ID, typeEvaluation.designation, session, intitule_cours, date_evaluation, vacation, Sections.id
            FROM Sections INNER JOIN (Departements INNER JOIN (Promotions INNER JOIN(Evaluations INNER JOIN typeEvaluation ON typeEvaluation.id = Evaluations.type_ID)
            ON Evaluations.promotion_ID = Promotions.id) ON Promotions.departement_ID = Departements.id) ON Departements.section_ID = Sections.id
            WHERE Sections.id =$id ORDER BY date_evaluation");
        }elseif($_SESSION['type'] == 'Jury'){
            $query = $db->query("SELECT Evaluations.id as idEval, Jury.promotion_ID as promotion_ID, typeEvaluation.designation, session, intitule_cours, date_evaluation, vacation, Jury.id
            FROM Jury INNER JOIN (Promotions INNER JOIN(Evaluations INNER JOIN typeEvaluation ON typeEvaluation.id = Evaluations.type_ID)
            ON Evaluations.promotion_ID = Promotions.id) ON Promotions.id = Jury.promotion_ID
            WHERE Jury.id =$id ORDER BY date_evaluation");
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getAllEvaluationsTypes(){
        $db = db_connection();

        $query = $db->query("SELECT * FROM typeEvaluation");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    function getTypeByName(string $name){
        $db = db_connection();

        $query = $db->query("SELECT * FROM typeEvaluation WHERE designation='$name'");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    function getAllStudentsAffectations(){
        $db = db_connection();

        $query = $db->query("SELECT nomSalle, Promotions.id as idPromot, Departements.id as idDep, EtreAffecte.id as idAffect, Etudiants.id as idEtud, nom, postnom, prenom, sexe, Departements.sigle as nomDepart, Promotions.designation as promotion, dateAffectation
        FROM Departements INNER JOIN (Promotions INNER JOIN(Etudiants INNER JOIN(EtreAffecte INNER JOIN Salles ON Salles.id = EtreAffecte.Salle_ID) ON Etudiants.id = EtreAffecte.student_ID) ON Etudiants.promotion_ID = Promotions.id) ON Promotions.departement_ID = Departements.id
        ORDER BY dateAffectation");

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getStudentAffectationByDate(string $date){
        $db = db_connection();

        $query = $db->query("SELECT nomSalle, Promotions.id as idPromot, Departements.id as idDep, EtreAffecte.id as idAffect, Etudiants.id as idEtud, nom, postnom, prenom, sexe, Departements.sigle as nomDepart, Promotions.designation as promotion, dateAffectation
        FROM Departements INNER JOIN (Promotions INNER JOIN(Etudiants INNER JOIN(EtreAffecte INNER JOIN Salles ON Salles.id = EtreAffecte.Salle_ID) ON Etudiants.id = EtreAffecte.student_ID) ON Etudiants.promotion_ID = Promotions.id) ON Promotions.departement_ID = Departements.id
        WHERE dateAffectation = '$date' ORDER BY dateAffectation");

        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }


    function getAllSurveillances(){
        $db = db_connection();

        $query = $db->query("SELECT Surveiller.id as id, CONCAT(grade, ' ', nomComplet) as nomSurv, Surveiller.surveillantID as idSurv, Surveiller.salleID as idSalle, dateSurveillance, vacation, timeIn, timeOut, nomSalle, Surveiller.salleID as idSalle
        FROM Surveillants INNER JOIN(Surveiller INNER JOIN Salles ON Salles.id= Surveiller.salleID) ON Surveiller.surveillantID = Surveillants.id
        ORDER BY dateSurveillance, nomSalle, vacation, nomSurv");

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $nbre = $query->rowCount();
        
        //die(var_dump($nbre));
        return $result;
    }

    function getSallesByDateSurveillance(string $date){
        $db = db_connection();

        $query = $db->query("SELECT DISTINCT Salles.id as idS, nomSalle, capacite FROM Salles INNER JOIN Surveiller ON Surveiller.salleID = Salles.id 
        WHERE Surveiller.dateSurveillance = '$date' GROUP BY nomSalle");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getVacationBySalle(int $idSalle){
        $db = db_connection();

        $query = $db->query("SELECT * FROM Salles INNER JOIN Surveiller ON Surveiller.salleID = Salles.id 
        WHERE Surveiller.salleID = '$idSalle' GROUP BY Surveiller.salleID ORDER BY vacation");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getAllStudentsAttendances(){
        $db = db_connection();

        $query = $db->query("SELECT  Etudiants.id as idEtud, CONCAT(nom, ' ', postnom, ' ', prenom) as noms, date_presence, time_in, time_out, intitule_cours as cours
        FROM Etudiants INNER JOIN (Passer INNER JOIN Evaluations ON Evaluations.id = Passer.evaluation_ID) 
        ON Passer.etudiant_ID = Etudiants.id WHERE Etudiants.id = (SELECT student_ID FROM EtreAffecte WHERE dateAffectation = date_presence AND student_ID = Etudiants.id)
        ORDER BY date_presence DESC");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    function getStudentsAttendancesByUsertype(){
        $db = db_connection();
        $id = $_SESSION['id'];

        if($_SESSION['type'] == 'Section'){
            $query = $db->query("SELECT  Etudiants.id as idEtud, CONCAT(nom, ' ', postnom, ' ', prenom) as noms, date_presence, time_in, time_out, intitule_cours as cours, sections.id as idSect
            FROM Sections INNER JOIN(Departements INNER JOIN(Promotions INNER JOIN (Etudiants INNER JOIN (Passer INNER JOIN Evaluations ON Evaluations.id = Passer.evaluation_ID) 
            ON Passer.etudiant_ID = Etudiants.id) ON Etudiants.promotion_ID = Promotions.id) ON Promotions.departement_ID = Departements.id) ON Departements.section_ID = Sections.id
            WHERE Sections.id = $id AND Etudiants.id IN (SELECT student_ID FROM EtreAffecte WHERE dateAffectation = date_presence)
            ORDER BY date_presence DESC");
        }elseif($_SESSION['type'] == 'Jury'){
            $query = $db->query("SELECT  Etudiants.id as idEtud, CONCAT(nom, ' ', postnom, ' ', prenom) as noms, date_presence, time_in, time_out, intitule_cours as cours, Jury.id as idJ
            FROM Jury INNER JOIN(Promotions INNER JOIN (Etudiants INNER JOIN (Passer INNER JOIN Evaluations ON Evaluations.id = Passer.evaluation_ID) 
            ON Passer.etudiant_ID = Etudiants.id) ON Etudiants.promotion_ID = Promotions.id) ON Promotions.id = Jury.promotion_ID
            WHERE Jury.id = $id AND Etudiants.id IN (SELECT student_ID FROM EtreAffecte WHERE dateAffectation = date_presence)
            ORDER BY date_presence DESC");
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    function getAffectationSurveillantByDate(string $date){
        $db = db_connection();

        $query = $db->query("SELECT nomSalle, CONCAT(grade, ' ', nomComplet) as noms, sexe, vacation, dateSurveillance
        FROM Surveillants INNER JOIN (Surveiller INNER JOIN Salles ON Salles.id = Surveiller.SalleID) ON Surveiller.surveillantID = Surveillants.id
        WHERE dateSurveillance = '$date' ");

        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
?>