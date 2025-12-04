<?php
function is_compatible($donor_bg, $donor_rh, $seeker_bg, $seeker_rh) {
    // ABO compatibility
    $abo_match = ($donor_bg == $seeker_bg) || ($donor_bg == 'O') || ($seeker_bg == 'AB');
    // Rh compatibility
    $rh_match = ($donor_rh == $seeker_rh) || ($donor_rh == '-' && $seeker_rh == '+');
    return $abo_match && $rh_match;
}
?>
