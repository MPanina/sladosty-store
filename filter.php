<?php
echo "<div class='form__genres'>";
foreach ($genreSelectResult as $genreRow) {
    echo "<div class='aside__checkbox checkbox'>";
    echo "<label for='" . $genreRow['name'] . "' class='checkbox__label'>" . $genreRow['name'] . "</label>";
    echo "<input type='checkbox' name='genres[]' id='" . $genreRow['name'] . "' value='" . $genreRow['name'] . "'>";
    echo "</div>";
}
echo "</div>";

