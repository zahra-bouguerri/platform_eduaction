<?php
include "./includes/header.php";
include "./includes/topmenu.php";

// Fetch existing Filières from the database
$fetchFiliereQuery = "SELECT * FROM Filière where year_id = 2";
$fetchFiliereResult = $conn->query($fetchFiliereQuery);
?>

<!-- Rest of your HTML code -->

<div id="addUnitModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeAddUnitModal()">&times;</span>
    <h2>إضافة وحدة تعليمية</h2>
    <form method="POST">
      <label for="branch">الشعبة:</label><br>
      <select id="branch" name="branch" required>
        <option value="" disabled selected>اختر الشعبة</option>
        <?php
        // Populate the select options with existing Filières
        if ($fetchFiliereResult->num_rows > 0) {
          while ($row = $fetchFiliereResult->fetch_assoc()) {
            echo "<option value='" . $row['field_id'] . "'>" . $row['field_name'] . "</option>";
          }
        }
        ?>
      </select><br>

      <label for="unitName">ادخل اسم الوحدة:</label><br>
      <input type="text" id="unitName" name="unitName" required>
      <label for="cours"> حالة  </label>
      <select name="etat" class="niveau" >
                  <option value=""> --اختر--</option>
                 <option value=" جديد"> جديد</option>
                </select>
      <button type="submit" name="Ajouter">إضافة</button>
    </form>
  </div>
</div>

<?php
if (isset($_POST['Ajouter'])) {
  $branch = $_POST['branch'];
  $unitName = $_POST['unitName'];
  $etat=$_POST['etat'];
  // Check if the Chapitre already exists in the selected Filière
  $checkQuery = "SELECT * FROM Chapitre WHERE chapter_name = '$unitName' AND filiere_id = '$branch'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    echo "<script>alert('هذه الوحدة التعليمية موجودة بالفعل في الشعبة المحددة.');</script>";
  } else {
    // Insert the new Chapitre record into the database
    $insertQuery = "INSERT INTO Chapitre (chapter_name, filiere_id,etat) VALUES ('$unitName', '$branch','$etat')";
    if ($conn->query($insertQuery) === TRUE) {
      echo "<script>alert('تمت إضافة الوحدة التعليمية بنجاح.');</script>";
    } else {
      echo "Error: ";
    }
  }
}
?>
<!--end add chapitre-->



  
  <div id="addPartModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeAddPartModal()">&times;</span>
    <h2>إضافة وحدة جزئية</h2>
    <form method="POST" action="">
      <label for="branch">الشعبة:</label>
      <select id="branch" name="branch" required onchange="loadChapters(this.value)">
        <option value="" disabled selected>اختر الشعبة</option>
        <?php
        // Exécutez la requête SQL pour sélectionner les noms des filières
        $sql = "SELECT field_name, field_id FROM Filière where year_id=2";
        $result = $conn->query($sql);

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Parcourez les résultats et générez les options
            while ($row = $result->fetch_assoc()) {
                $field_id = $row['field_id'];
                $field_name = $row['field_name'];
                echo '<option value="' . $field_id . '">' . $field_name . '</option>';
            }
        } else {
            echo '<option value="">Aucune filière trouvée</option>';
        }
        ?>
      </select>
      <label for="chapter">الوحدة التعلمية: </label>
      <select id="chapter" name="chapter" required>
        <option value="" disabled selected>اختر الوحدة التعليمية</option>
      </select>

      
      <label for="subchapter">الوحدة الجزئية:</label>
      <input type="text" id="subchapter" name="Sunit" required>
      <button type="submit" name="addS">إضافة</button>
    </form>
  </div>
</div>

<?php
if (isset($_POST['addS'])) {
  $branch = $_POST['branch'];
  $unitName = $_POST['chapter'];
  $Sunit = $_POST['Sunit'];

  // Check if the Chapitre already exists in the selected Filière
  $checkQuery = "SELECT * FROM sous_chapitre WHERE subchapter_name = '$Sunit' AND chapter_id = '$unitName'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    echo "<script>alert('هذه الوحدة الجزئية موجودة بالفعل في الوحدة المحددة.');</script>";
  } else {
    // Insert the new Chapitre record into the database
    $insertQuery = "INSERT INTO sous_chapitre (subchapter_name, chapter_id) VALUES ('$Sunit', '$unitName')";
    if ($conn->query($insertQuery) === TRUE) {
      echo "<script>alert('تمت إضافة الوحدة الجزئية بنجاح.');</script>";
    } else {
      echo "Error: ";
    }
  }
}
?>

<!--end add sous chapitre-->
  
            <div id="addCourModal" class="modal">
              <div class="modal-content">
                <span class="close" onclick="closeAddCourModal()">&times;</span>
                <h2>إضافة عنوان درس</h2>
                <form method="POST">
                  <label for="branch">الشعبة:</label>
                  <select id="branch2" name="branch" required onchange="loadChapters2(this.value)">
                  <option value="" disabled selected>اختر الشعبة</option>
        <?php
        // Exécutez la requête SQL pour sélectionner les noms des filières
        $sql = "SELECT field_name, field_id FROM Filière where year_id=2";
        $result = $conn->query($sql);

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Parcourez les résultats et générez les options
            while ($row = $result->fetch_assoc()) {
                $field_id = $row['field_id'];
                $field_name = $row['field_name'];
                echo '<option value="' . $field_id . '">' . $field_name . '</option>';
            }
        } else {
            echo '<option value="">Aucune filière trouvée</option>';
        }
        ?>
             </select>

                  <label for="chapter">الوحدة التعلمية: </label>
                  <select id="chapter2" name="chapter" required onchange="loadSubchapters(this.value)">
                  <option value="" disabled selected>اختر الوحدة التعليمية</option>
                 </select>
                 
  
                  <label for="subchapter">الوحدة الجزيئية: </label>
                  <select id="subchapter2" name="subchapter2" required>
                    <option value="" disabled selected>اختر الوحدة الجزئية</option>
                  </select>
  
                  <label for="cours"> اضافة عنوان درس</label>
                  <input type="text" id="cours" name="cours" required>
                  <label for="cours"> حالة  </label>
                  <select name="etat" class="niveau" >
                  <option value=""> --اختر--</option>
                 <option value=" جديد"> جديد</option>
                </select>
                  <button type="submit" name="addc">إضافة</button>
                </form>
              </div>
            </div>

            <?php
if (isset($_POST['addc'])) {
  $subchapter = $_POST['subchapter2'];
  $courseTitle = $_POST['cours'];
  $etat=$_POST['etat'];
  // Check if the Chapitre already exists in the selected Filière
  $checkQuery = "SELECT * FROM cours WHERE course_name = '$courseTitle' AND subchapter_id = '$subchapter'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    echo "<script>alert('هذه  الدرس موجودة بالفعل في الوحدة .');</script>";
  } else {
    // Insert the new Chapitre record into the database
    $insertQuery = "INSERT INTO cours (course_name, subchapter_id,etat) VALUES ('$courseTitle', '$subchapter','$etat')";
    if ($conn->query($insertQuery) === TRUE) {
      echo "<script>alert('تمت إضافة عنوان الدرس بنجاح.');</script>";
    } else {
      echo "<script>alert('حدث خطأ أثناء إضافة عنوان الدرس.');</script>";
    }
  }
}
?>
          <!--start delete chapitre-->

<!-- fenetre flottante delete -->
    <div id="DeleteUnitModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteUnitModal()">&times;</span>
        <h2>حذف الوحدة التعلمية:</h2>
        <form id="deleteUnitForm" method="post">
            <label for="branch">الشعبة:</label><br>
            <select id="branch3" name="branch" required onchange="loadChapters3(this.value)">
            <option value="" disabled selected>اختر الشعبة</option>
            <?php
              // Exécutez la requête SQL pour sélectionner les noms des filières
              $sql = "SELECT field_name, field_id FROM Filière where year_id=2";
              $result = $conn->query($sql);

              // Vérifiez s'il y a des résultats
              if ($result->num_rows > 0) {
                  // Parcourez les résultats et générez les options
                  while ($row = $result->fetch_assoc()) {
                      $field_id = $row['field_id'];
                      $field_name = $row['field_name'];
                      echo '<option value="' . $field_id . '">' . $field_name . '</option>';
                  }
              } else {
                  echo '<option value="">Aucune filière trouvée</option>';
              }
        ?>
    
            </select><br>

            <label for="unitName">اختر الوحدات التعليمية المراد حذفها </label>
            <div id="sequenceSelection" >
               <!-- Les cases à cocher seront générées dynamiquement en JavaScript -->
            </div>

              
      <button type="submit" name="supprimerSequence">حذف</button>
        </form>
    </div>
</div>


<?php
if (isset($_POST['supprimerSequence'])) {
// Vérifier si des subchapitre  ont été sélectionnés pour la suppression
if (isset($_POST['sequencesToDelete']) && is_array($_POST['sequencesToDelete'])) {
  // Récupérer les ID des cours sélectionnés pour la suppression
  $sequencesToDelete = $_POST['sequencesToDelete'];

  // Vérifier s'il existe des enregistrements liés dans les autres tables
  $linkedRecords = array();
  foreach ($sequencesToDelete as $sequenceId) {
    $checkLinkedQuery = "SELECT * FROM sous_chapitre  WHERE chapter_id = '$sequenceId' LIMIT 1";
    $linkedResult = $conn->query($checkLinkedQuery);
    if ($linkedResult->num_rows > 0) {
      $linkedRecords[] = $sequenceId;
    }
    // Vérifiez également les autres tables liées ici et ajoutez les ID de cours liés à $linkedRecords si nécessaire
  }

  if (!empty($linkedRecords)) {
    // Certains cours ont des enregistrements liés, affichez le message d'erreur
    $sequencesList = implode(", ", $linkedRecords);
     echo "<script>alert(' لا يمكن حذف الوحدة لاانها تحتوي على وحدات جزئية يرجى حذفهم اولا');</script>";
  } else {
    // Aucun enregistrement lié trouvé, procédez à la suppression des cours
    $sequenceIds = implode("','", $sequencesToDelete);
    $deletesequencesQuery = "DELETE FROM chapitre WHERE chapter_id IN ('$sequenceIds')";
    if ($conn->query($deletesequencesQuery)) {
      echo "<script>alert('تم حذف الوحدات بنجاح.');</script>";
    } else {
      echo "Error: " . $conn->error;
    }
  }
} else {
  echo "<script>alert('يرجى تحديد الوحدات التي تريد حذفها.');</script>";
}
}
?>







         <!--end delete chapitre-->
  
<div id="DeletePartModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeDeletePartModal()">&times;</span>
    <h2> حذف وحدة جزئية</h2>
    <form id="DeleteSubChap" method="post">
      <label for="branch">الشعبة:</label>
      <select id="branch6" name="branch" required onchange="loadChapters5(this.value)">
        <option value="" disabled selected>اختر الشعبة</option>
        <?php
        // Exécutez la requête SQL pour sélectionner les noms des filières
        $sql = "SELECT field_name, field_id FROM Filière where year_id=2";
        $result = $conn->query($sql);

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Parcourez les résultats et générez les options
            while ($row = $result->fetch_assoc()) {
                $field_id = $row['field_id'];
                $field_name = $row['field_name'];
                echo '<option value="' . $field_id . '">' . $field_name . '</option>';
            }
        } else {
            echo '<option value="">Aucune filière trouvée</option>';
        }
        ?>
      </select>

      <label for="chapter">الوحدة التعلمية: </label>
      <select id="chapter5" name="chapter" required onchange="loadSubchapters5(this.value)">
        <option value="" disabled selected>اختر الوحدة التعليمية</option>
      </select>
      <label for="unitName">اختر الوحدات الجزئية المراد حذفها </label>
      <div id="subChapSelection" >
        <!-- Les cases à cocher seront générées dynamiquement en JavaScript -->
      </div>
    
           
            
      
      <button type="submit" name="deletesub">حذف</button>
    </form>
  </div>
</div>
<?php
if (isset($_POST['deletesub'])) {
  // Vérifier si des subchapitre  ont été sélectionnés pour la suppression
  if (isset($_POST['subchaptersToDelete']) && is_array($_POST['subchaptersToDelete'])) {
    // Récupérer les ID des cours sélectionnés pour la suppression
    $subchaptersToDelete = $_POST['subchaptersToDelete'];

    // Vérifier s'il existe des enregistrements liés dans les autres tables
    $linkedRecords = array();
    foreach ($subchaptersToDelete as $subchapterId) {
      $checkLinkedQuery = "SELECT * FROM cours  WHERE subchapter_id = '$subchapterId' LIMIT 1";
      $linkedResult = $conn->query($checkLinkedQuery);
      if ($linkedResult->num_rows > 0) {
        $linkedRecords[] = $suchapterId;
      }
      // Vérifiez également les autres tables liées ici et ajoutez les ID de cours liés à $linkedRecords si nécessaire
    }
  
    if (!empty($linkedRecords)) {
      // Certains cours ont des enregistrements liés, affichez le message d'erreur
      $subchaptersList = implode(", ", $linkedRecords);
       echo "<script>alert(' لا يمكن حذف الوحدة لاانها تحتوي على دروس يرجى حذفهم اولا');</script>";
    } else {
      // Aucun enregistrement lié trouvé, procédez à la suppression des cours
      $subchapterIds = implode("','", $subchaptersToDelete);
      $deletesubchaptersQuery = "DELETE FROM sous_chapitre WHERE subchapter_id IN ('$subchapterIds')";
      if ($conn->query($deletesubchaptersQuery)) {
        echo "<script>alert('تم حذف الوحدات بنجاح.');</script>";
      } else {
        echo "Error: " . $conn->error;
      }
    }
  } else {
    echo "<script>alert('يرجى تحديد الوحدات التي تريد حذفها.');</script>";
  }
}
?>




<div id="DeleteCourModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeDeleteCourModal()">&times;</span>
    <h2>حذف عنوان درس</h2>
    
    <form id="deleteCourseForm" method="post">
      <label for="branch">الشعبة:</label>
      <select id="branch7" name="branch" required onchange="loadChapters7(this.value)">
        <option value="" disabled selected>اختر الشعبة</option>
        <?php
        // Exécutez la requête SQL pour sélectionner les noms des filières
        $sql = "SELECT field_name, field_id FROM Filière where year_id=2";
        $result = $conn->query($sql);

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Parcourez les résultats et générez les options
            while ($row = $result->fetch_assoc()) {
                $field_id = $row['field_id'];
                $field_name = $row['field_name'];
                echo '<option value="' . $field_id . '">' . $field_name . '</option>';
            }
        } else {
            echo '<option value="">Aucune filière trouvée</option>';
        }
        ?>
      </select>

      <label for="chapter">الوحدة التعلمية: </label>
      <select id="chapter7" name="chapter" required onchange="loadSubchapters7(this.value)">
        <option value="" disabled selected>اختر الوحدة التعليمية</option>
      </select>

      <label for="subchapter">الوحدة الجزيئية: </label>
      <select id="subchapter7" name="subchapter2" required onchange=" loadCours1(this.value)">
        <option value="" disabled selected>اختر الوحدة الجزئية</option>
      </select>

      <label for="unitName">الدروس المراد حذفها</label>
      <div id="unitSelection" >
        <!-- Les cases à cocher seront générées dynamiquement en JavaScript -->
      </div>
      <button type="submit" name ="supprimerLecon">حذف</button>
    </form>
  </div>
</div>
<?php
if (isset($_POST['supprimerLecon'])) {
  // Vérifier si des cours ont été sélectionnés pour la suppression
  if (isset($_POST['coursesToDelete']) && is_array($_POST['coursesToDelete'])) {
    // Récupérer les ID des cours sélectionnés pour la suppression
    $coursesToDelete = $_POST['coursesToDelete'];

    // Vérifier s'il existe des enregistrements liés dans les autres tables
    $linkedRecords = array();
    foreach ($coursesToDelete as $courseId) {
      $checkLinkedQuery = "SELECT * FROM quiz WHERE course_id = '$courseId' LIMIT 1";
      $linkedResult = $conn->query($checkLinkedQuery);
      if ($linkedResult->num_rows > 0) {
        $linkedRecords[] = $courseId;
      }
      // Vérifiez également les autres tables liées ici et ajoutez les ID de cours liés à $linkedRecords si nécessaire
    }

    if (!empty($linkedRecords)) {
      // Certains cours ont des enregistrements liés, affichez le message d'erreur
      $coursesList = implode(", ", $linkedRecords);
      echo "<script>alert('لا يمكن حذف الدروس التالية لأنها تحتوي على تقويمات أو فيديوهات أو ملفات PDF: $coursesList. يرجى حذفهم أولاً.');</script>";
    } else {
      // Aucun enregistrement lié trouvé, procédez à la suppression des cours
      $courseIds = implode("','", $coursesToDelete);
      $deleteCoursesQuery = "DELETE FROM cours WHERE course_id IN ('$courseIds')";
      if ($conn->query($deleteCoursesQuery)) {
        echo "<script>alert('تم حذف الدروس بنجاح.');</script>";
      } else {
        echo "Error: " . $conn->error;
      }
    }
  } else {
    echo "<script>alert('يرجى تحديد الدروس التي تريد حذفها.');</script>";
  }
}
?>



<div id="EditUnitModal" class="modal">
              <div class="modal-content">
                <span class="close" onclick="closeEditUnitModal()">&times;</span>
                <h2>تعديل وحدة تعليمية</h2>
                <form id= "EditSeqForm" method="post">
                  <label for="branch">الشعبة:</label>
                  <select id="branch4" name="branch2" required onchange="loadChapters6(this.value)">
                  <option value="" disabled selected>اختر الشعبة</option>
        <?php
        // Exécutez la requête SQL pour sélectionner les noms des filières
        $sql = "SELECT field_name, field_id FROM Filière where year_id=2";
        $result = $conn->query($sql);

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Parcourez les résultats et générez les options
            while ($row = $result->fetch_assoc()) {
                $field_id = $row['field_id'];
                $field_name = $row['field_name'];
                echo '<option value="' . $field_id . '">' . $field_name . '</option>';
            }
        } else {
            echo '<option value="">Aucune filière trouvée</option>';
        }
        ?>
             </select>
                  <label for="branch">الوحدة التعلمية: </label>
                  <select id="chapter6" name="chapter" required >
                  <option value="" disabled selected>    اختر الوحدة التعليمية المراد تعديلها</option>
                </select>
                  
                  <label for="unitName">  الوحدة التعليمية  الجديدة </label>
                  <input type="text" id="unitName" name="unitName" required>
                  <button type="submit" name ="modifiersequence">تعديل</button>
                </form>
              </div>
            </div>
            <?php
// Assurez-vous que vous avez une connexion à la base de données établie avant cette partie du code.

if (isset($_POST['modifiersequence'])) {
    // Récupérer les valeurs des champs du formulaire
    $branchId = $_POST['branch2'];
    $chapterId = $_POST['chapter'];
    $newSubchapterName = $_POST['unitName'];

    // Vérifier si la sous-unité existe déjà dans la base de données pour cette branche et ce chapitre
    $checkQuery = "SELECT * FROM chapitre WHERE chapter_name = '$newSubchapterName' AND chapter_id = '$branchId'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('هذه الوحدة التعليمية موجودة بالفعل في الشعبة والوحدة التعلمية المحددة.');</script>";
    } else {
        // Mettre à jour la sous-unité (وحدة جزئية) dans la base de données
        $updateQuery = "UPDATE chapitre SET chapter_name = '$newSubchapterName' WHERE chapter_id = '$chapterId'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>alert('تم تعديل الوحدة الجزئية بنجاح.');</script>";
        } else {
            echo "Erreur : " . $conn->error;
        }
    }
  }
   

?>









 











            
           

            <div id="EditPartModal" class="modal">
              <div class="modal-content">
                <span class="close" onclick="closeEditPartModal()">&times;</span>
                <h2> تعديل وحدة جزئية</h2>
                <form id="editPartForm" method="post">
                  <label for="branch">الشعبة:</label>
                  <select id="branch5" name="branch" required onchange="loadChapters6(this.value)">
                  <option value="" disabled selected>اختر الشعبة</option>
        <?php
        // Exécutez la requête SQL pour sélectionner les noms des filières
        $sql = "SELECT field_name, field_id FROM Filière where year_id=2";
        $result = $conn->query($sql);

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Parcourez les résultats et générez les options
            while ($row = $result->fetch_assoc()) {
                $field_id = $row['field_id'];
                $field_name = $row['field_name'];
                echo '<option value="' . $field_id . '">' . $field_name . '</option>';
            }
        } else {
            echo '<option value="">Aucune filière trouvée</option>';
        }
        ?>
             </select>
                  <label for="branch">الوحدة التعلمية: </label>
                  <select id="chapter6" name="chapter" required onchange="loadSubchapters6(this.value)">
                  <option value="" disabled selected>اختر الوحدة التعليمية</option>
                </select>
                  <label for="branch">الوحدة الجزيئية  المراد تعديلها</label>
                  <select id="subchapter6" name="subchapter" required>
                    <option value="" disabled selected>اختر الوحدة الجزئية</option>
                
                  </select>
                  <label for="unitName">  الوحدة الجزيئية  الجديدة </label>
                  <input type="text" id="unitName" name="unitName" required>
                  <button type="submit" name ="modifierSequence">تعديل</button>
                </form>
              </div>
            </div>
            <?php
// Assurez-vous que vous avez une connexion à la base de données établie avant cette partie du code.

if (isset($_POST['modifierSequence'])) {
    // Récupérer les valeurs des champs du formulaire
    $branchId = $_POST['branch'];
    $chapterId = $_POST['chapter'];
    $subchapterId = $_POST['subchapter'];
    $newSubchapterName = $_POST['unitName'];

    // Vérifier si la sous-unité existe déjà dans la base de données pour cette branche et ce chapitre
    $checkQuery = "SELECT * FROM sous_chapitre WHERE subchapter_name = '$newSubchapterName' AND chapter_id = '$chapterId'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('هذه الوحدة الجزئية موجودة بالفعل في الشعبة والوحدة التعلمية المحددة.');</script>";
    } else {
        // Mettre à jour la sous-unité (وحدة جزئية) dans la base de données
        $updateQuery = "UPDATE sous_chapitre SET subchapter_name = '$newSubchapterName' WHERE subchapter_id = '$subchapterId'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>alert('تم تعديل الوحدة الجزئية بنجاح.');</script>";
        } else {
            echo "Erreur : " . $conn->error;
        }
    }
  }
       
      
?>











            <div id="EditCourModal" class="modal">
              <div class="modal-content">
                <span class="close" onclick="closeEditCourModal()">&times;</span>
                <h2>تعديل عنوان درس</h2>
                
                <form id="editModelForm" method="post">
                  <label for="branch">الشعبة:</label>
                  <select id="branch8" name="branch" required onchange="loadChapters8(this.value)">
                  <option value="" disabled selected>اختر الشعبة</option>
        <?php
        // Exécutez la requête SQL pour sélectionner les noms des filières
        $sql = "SELECT field_name, field_id FROM Filière where year_id=2";
        $result = $conn->query($sql);

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Parcourez les résultats et générez les options
            while ($row = $result->fetch_assoc()) {
                $field_id = $row['field_id'];
                $field_name = $row['field_name'];
                echo '<option value="' . $field_id . '">' . $field_name . '</option>';
            }
        } else {
            echo '<option value="">Aucune filière trouvée</option>';
        }
        ?>
             </select>

                  <label for="chapter">الوحدة التعلمية: </label>
                  <select id="chapter8" name="chapter" required onchange="loadSubchapters8(this.value)">
                  <option value="" disabled selected>اختر الوحدة التعليمية</option>
                 </select>
                 
  
                  <label for="subchapter">الوحدة الجزيئية: </label>
                  <select id="subchapter8" name="subchapter2" required onchange="loadCours2(this.value)">
                   <option value="" disabled selected>اختر الوحدة الجزئية</option>
               </select>
                  <label >عنوان الدرس المراد تعديله</label>
                  <select id="coursUpdate" name="cours" required>
                  <option value="" disabled selected>اختر درس</option>
               </select>
                  <label > عنوان الدرس  الجديد</label>
                  <input type="text" id="unitName" name="unitName" required>
                  <button type="submit" name="modifiercour">تعديل</button>
                </form>
              </div>
            
        </div>
 
      </div>
    </div>
    <!-- PHP -->
<?php
if (isset($_POST['modifiercour'])) {
  $selectedCoursId = $_POST['cours'];
  $newCoursTitle = $_POST['unitName'];

  // Vérifier si le titre du cours existe déjà pour un autre cours
  $checkQuery = "SELECT * FROM cours WHERE course_name = '$newCoursTitle' AND course_id != '$selectedCoursId'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    echo "<script>alert('عفوًا ، يوجد بالفعل درس آخر بنفس العنوان. الرجاء اختيار عنوان جديد.');</script>";
  } else {
    // Mettre à jour le titre du cours dans la base de données
    $updateQuery = "UPDATE cours SET course_name = '$newCoursTitle' WHERE course_id = '$selectedCoursId'";
    if ($conn->query($updateQuery) === TRUE) {
      echo "<script>alert('تم تعديل عنوان الدرس بنجاح.');</script>";
    } else {
      echo "Erreur : " . $conn->error;
    }
  }
}
?>

     
</body>
   <script src="./assets/js/script.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <script>
function loadChapters(branchId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var chapters = JSON.parse(this.responseText);
      var chapterSelect = document.getElementById('chapter');
      
      // Clear the select options before populating
      chapterSelect.innerHTML = '';

      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة التعليمية";
      chapterSelect.appendChild(initialOption);

      // Populate the select with the filtered chapters
      for (var i = 0; i < chapters.length; i++) {
        var option = document.createElement('option');
        option.value = chapters[i].chapter_id;
        option.text = chapters[i].chapter_name;
        chapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_chapters.php?branchId=" + branchId, true);
  xhttp.send();
}

  function loadChapters2(branchId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var chapters = JSON.parse(this.responseText);
      var chapterSelect = document.getElementById('chapter2');

      // Clear the select options before populating
      chapterSelect.innerHTML = '';

      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة التعليمية";
      chapterSelect.appendChild(initialOption);

      // Populate the select with the filtered chapters
      for (var i = 0; i < chapters.length; i++) {
        var option = document.createElement('option');
        option.value = chapters[i].chapter_id;
        option.text = chapters[i].chapter_name;
        chapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_chapters.php?branchId=" + branchId, true);
  xhttp.send();
}

function loadChapters3(branchId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var chapters = JSON.parse(this.responseText);
      var sequenceSelection = document.getElementById('sequenceSelection');

      // Clear previous checkboxes
      sequenceSelection.innerHTML = '';

      // Generate checkboxes for the chapters
      for (var i = 0; i < chapters.length; i++) {
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'sequencesToDelete[]'; // The name with [] allows sending as an array in POST
        checkbox.value = chapters[i].chapter_id;
        checkbox.id = 'sequence_' + chapters[i].chapter_id;

        var label = document.createElement('label');
        label.innerHTML = chapters[i].chapter_name;
        label.setAttribute('for', 'sequence_' + chapters[i].chapter_id);

        sequenceSelection.appendChild(checkbox);
        sequenceSelection.appendChild(label);
        sequenceSelection.appendChild(document.createElement('br'));
      }
    }
  };
  xhttp.open("GET", "get_chapters.php?branchId=" + branchId, true);
  xhttp.send();
}



function loadChapters5(branchId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var chapters = JSON.parse(this.responseText);
      var chapterSelect = document.getElementById('chapter5');

      // Clear the select options before populating
      chapterSelect.innerHTML = '';

      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة التعليمية";
      chapterSelect.appendChild(initialOption);

      // Populate the select with the filtered chapters
      for (var i = 0; i < chapters.length; i++) {
        var option = document.createElement('option');
        option.value = chapters[i].chapter_id;
        option.text = chapters[i].chapter_name;
        chapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_chapters.php?branchId=" + branchId, true);
  xhttp.send();
}

function loadChapters6(branchId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var chapters = JSON.parse(this.responseText);
      var chapterSelect = document.getElementById('chapter6');

      // Clear the select options before populating
      chapterSelect.innerHTML = '';


      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة التعليمية";
      chapterSelect.appendChild(initialOption);

      // Populate the select with the filtered chapters
      for (var i = 0; i < chapters.length; i++) {
        var option = document.createElement('option');
        option.value = chapters[i].chapter_id;
        option.text = chapters[i].chapter_name;
        chapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_chapters.php?branchId=" + branchId, true);
  xhttp.send();
}

  function loadSubchapters(chapitreId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var subchapters = JSON.parse(this.responseText);
      var subchapterSelect = document.getElementById('subchapter2');
      
      // Clear the select options before populating
      subchapterSelect.innerHTML = '';
      
      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة الجزئية";
      subchapterSelect.appendChild(initialOption);

      // Populate the select with the filtered subchapters
      for (var i = 0; i < subchapters.length; i++) {
        var option = document.createElement('option');
        option.value = subchapters[i].subchapter_id;
        option.text = subchapters[i].subchapter_name;
        subchapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_schapters.php?chapitreId=" + chapitreId, true);
  xhttp.send();
}
function loadSubchapters5(chapitreId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var subchapters = JSON.parse(this.responseText);
      var subChapSelection = document.getElementById('subChapSelection');

      // Clear the previous checkboxes before populating
      subChapSelection.innerHTML = '';

      // Populate the div with the checkboxes for the subchapters
      for (var i = 0; i < subchapters.length; i++) {
        var subchapter = subchapters[i];

        // Create a new checkbox for each subchapter
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'subchaptersToDelete[]';
        checkbox.value = subchapter.subchapter_id;
        checkbox.id = 'subchapter' + subchapter.subchapter_id;

        // Create a label for the checkbox
        var label = document.createElement('label');
        label.htmlFor = 'subchapter' + subchapter.subchapter_id;
        label.textContent = subchapter.subchapter_name;

        // Append the checkbox and the label to the div
        subChapSelection.appendChild(checkbox);
        subChapSelection.appendChild(label);
        subChapSelection.appendChild(document.createElement('br')); // Line break for spacing
      }
    }
  };
  xhttp.open("GET", "get_schapters.php?chapitreId=" + chapitreId, true);
  xhttp.send();
}

function loadSubchapters6(chapitreId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var subchapters = JSON.parse(this.responseText);
      var subchapterSelect = document.getElementById('subchapter6');
      
      // Clear the select options before populating
      subchapterSelect.innerHTML = '';
      
      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة الجزئية";
      subchapterSelect.appendChild(initialOption);

      // Populate the select with the filtered subchapters
      for (var i = 0; i < subchapters.length; i++) {
        var option = document.createElement('option');
        option.value = subchapters[i].subchapter_id;
        option.text = subchapters[i].subchapter_name;
        subchapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_schapters.php?chapitreId=" + chapitreId, true);
  xhttp.send();
}
function loadSubchapters7(chapitreId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var subchapters = JSON.parse(this.responseText);
      var subchapterSelect = document.getElementById('subchapter7');
      
      // Clear the select options before populating
      subchapterSelect.innerHTML = '';
      
      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة الجزئية";
      subchapterSelect.appendChild(initialOption);

      // Populate the select with the filtered subchapters
      for (var i = 0; i < subchapters.length; i++) {
        var option = document.createElement('option');
        option.value = subchapters[i].subchapter_id;
        option.text = subchapters[i].subchapter_name;
        subchapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_schapters.php?chapitreId=" + chapitreId, true);
  xhttp.send();
}

function loadSubchapters8(chapitreId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var subchapters = JSON.parse(this.responseText);
      var subchapterSelect = document.getElementById('subchapter8');

      // Clear the select options before populating
      subchapterSelect.innerHTML = '';

      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة الجزئية";
      subchapterSelect.appendChild(initialOption);

      // Populate the select with the filtered subchapters
      for (var i = 0; i < subchapters.length; i++) {
        var option = document.createElement('option');
        option.value = subchapters[i].subchapter_id;
        option.text = subchapters[i].subchapter_name;
        subchapterSelect.appendChild(option);
      }

      // Once the subchapters are loaded, load the corresponding courses for the selected subchapter
      var selectedSubchapterId = subchapterSelect.value;
      loadCours2(selectedSubchapterId);
    }
  };
  xhttp.open("GET", "get_schapters.php?chapitreId=" + chapitreId, true);
  xhttp.send();
}




function loadChapters7(branchId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var chapters = JSON.parse(this.responseText);
      var chapterSelect = document.getElementById('chapter7');

      // Clear the select options before populating
      chapterSelect.innerHTML = '';

      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة التعليمية";
      chapterSelect.appendChild(initialOption);

      // Populate the select with the filtered chapters
      for (var i = 0; i < chapters.length; i++) {
        var option = document.createElement('option');
        option.value = chapters[i].chapter_id;
        option.text = chapters[i].chapter_name;
        chapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_chapters.php?branchId=" + branchId, true);
  xhttp.send();
}
function loadChapters8(branchId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var chapters = JSON.parse(this.responseText);
      var chapterSelect = document.getElementById('chapter8');

      // Clear the select options before populating
      chapterSelect.innerHTML = '';

      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر الوحدة التعليمية";
      chapterSelect.appendChild(initialOption);

      // Populate the select with the filtered chapters
      for (var i = 0; i < chapters.length; i++) {
        var option = document.createElement('option');
        option.value = chapters[i].chapter_id;
        option.text = chapters[i].chapter_name;
        chapterSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_chapters.php?branchId=" + branchId, true);
  xhttp.send();
}

function loadCours1(subchapterId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var courses = JSON.parse(this.responseText);
      var unitSelection = document.getElementById('unitSelection');

      // Clear previous checkboxes
      unitSelection.innerHTML = '';

      // Generate checkboxes for the courses
      for (var i = 0; i < courses.length; i++) {
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'coursesToDelete[]'; // The name with [] allows sending as an array in POST
        checkbox.value = courses[i].course_id;
        checkbox.id = 'course_' + courses[i].course_id;

        var label = document.createElement('label');
        label.innerHTML = courses[i].course_name;
        label.setAttribute('for', 'course_' + courses[i].course_id);

        unitSelection.appendChild(checkbox);
        unitSelection.appendChild(label);
        unitSelection.appendChild(document.createElement('br'));
      }
    }
  };
  xhttp.open("GET", "get_cours.php?subchapterId=" + subchapterId, true);
  xhttp.send();
}

function loadCours2(subchapterId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var courses = JSON.parse(this.responseText);
      var coursSelect = document.getElementById('coursUpdate');

      // Clear the select options before populating
      coursSelect.innerHTML = '';

      // Add the initial empty and disabled option
      var initialOption = document.createElement('option');
      initialOption.value = "";
      initialOption.disabled = true;
      initialOption.selected = true;
      initialOption.textContent = "اختر درس";
      coursSelect.appendChild(initialOption);

      // Populate the select with the filtered cours
      for (var i = 0; i < courses.length; i++) {
        var option = document.createElement('option');
        option.value = courses[i].course_id;
        option.text = courses[i].course_name;
        coursSelect.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "get_cours.php?subchapterId=" + subchapterId, true);
  xhttp.send();
}



</script>
</html>
