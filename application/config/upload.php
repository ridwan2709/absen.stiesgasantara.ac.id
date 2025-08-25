<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File Upload Configuration
|--------------------------------------------------------------------------
|
| This file contains configuration for file uploads including:
| - Allowed file types
| - Maximum file sizes
| - Upload paths
| - Security settings
|
*/

// Upload directory configuration
$config['upload_path'] = './uploads/lecture_photos/';
$config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
$config['max_size'] = 5120; // 5MB in KB
$config['max_width'] = 0; // No width limit
$config['max_height'] = 0; // No height limit
$config['file_ext_tolower'] = TRUE;
$config['remove_spaces'] = TRUE;
$config['overwrite'] = FALSE;

// Security settings
$config['encrypt_name'] = FALSE; // We'll generate our own names
$config['detect_mime'] = TRUE;
$config['mod_mime_fix'] = TRUE;

// Image processing
$config['image_library'] = 'gd2';
$config['create_thumb'] = FALSE;
$config['maintain_ratio'] = TRUE;
$config['width'] = 0;
$config['height'] = 0;

// Error messages
$config['upload_error_msg'] = 'Upload gagal. Silakan coba lagi.';
$config['file_type_error_msg'] = 'Tipe file tidak didukung.';
$config['file_size_error_msg'] = 'Ukuran file terlalu besar.';

// Ensure upload directory exists and is writable
if (!is_dir($config['upload_path'])) {
    mkdir($config['upload_path'], 0755, TRUE);
}

// Set proper permissions
chmod($config['upload_path'], 0755);
