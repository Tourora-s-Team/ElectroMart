<?php
/**
 * Image Helper Functions
 * Utilities for handling image paths and URLs
 */

class ImageHelper
{
    /**
     * Chuyển đổi đường dẫn ảnh từ database thành URL web đúng
     * 
     * @param string $imagePath Đường dẫn từ database (vd: ./public/images/electro_mart/iphone15.jpg)
     * @return string URL web đúng (vd: https://electromart-t8ou8.ondigitalocean.app/public/images/electro_mart/iphone15.jpg)
     */
    public static function getImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return 'https://electromart-t8ou8.ondigitalocean.app/public/images/no-image.jpg';
        }

        // Xử lý đường dẫn từ database
        // Loại bỏ './' ở đầu nếu có
        $cleanPath = ltrim($imagePath, './');

        // Thêm prefix cho web
        $webUrl = 'https://electromart-t8ou8.ondigitalocean.app/' . $cleanPath;

        return $webUrl;
    }

    /**
     * Kiểm tra xem file ảnh có tồn tại không
     * 
     * @param string $imagePath Đường dẫn từ database
     * @return boolean
     */
    public static function imageExists($imagePath)
    {
        if (empty($imagePath)) {
            return false;
        }

        // Chuyển đổi thành đường dẫn file system
        $cleanPath = ltrim($imagePath, './');
        $fullPath = ROOT_PATH . '/' . $cleanPath;

        return file_exists($fullPath);
    }

    /**
     * Lấy URL ảnh với fallback nếu không tồn tại
     * 
     * @param string $imagePath Đường dẫn từ database
     * @param string $fallback Ảnh fallback mặc định
     * @return string
     */
    public static function getImageUrlWithFallback($imagePath, $fallback = 'https://electromart-t8ou8.ondigitalocean.app/public/images/no-image.jpg')
    {
        if (self::imageExists($imagePath)) {
            return self::getImageUrl($imagePath);
        }

        return $fallback;
    }
}
