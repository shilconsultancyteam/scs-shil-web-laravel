<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_url',
        'landing_page',
        'visit_count'
    ];

    /**
     * Get the domain from the referrer URL
     */
    public function getReferrerDomainAttribute()
    {
        $domain = parse_url($this->referrer_url, PHP_URL_HOST);
        return $domain ?: 'Direct';
    }

    /**
     * Get a clean display name for the referrer
     */
    public function getReferrerDisplayNameAttribute()
    {
        if ($this->referrer_url === 'direct') {
            return 'Direct Traffic';
        }

        $domain = $this->referrer_domain;
        
        // Map common domains to friendly names
        $friendlyNames = [
            'google.com' => 'Google',
            'facebook.com' => 'Facebook',
            'twitter.com' => 'Twitter',
            'linkedin.com' => 'LinkedIn',
            'instagram.com' => 'Instagram',
            'youtube.com' => 'YouTube',
            'github.com' => 'GitHub',
            'reddit.com' => 'Reddit',
            't.co' => 'Twitter',
            'l.instagram.com' => 'Instagram',
        ];

        return $friendlyNames[$domain] ?? $domain;
    }

    /**
     * Get the icon for the referrer
     */
    public function getReferrerIconAttribute()
    {
        $domain = $this->referrer_domain;

        $icons = [
            'direct' => 'fas fa-directory',
            'google.com' => 'fab fa-google',
            'facebook.com' => 'fab fa-facebook',
            'twitter.com' => 'fab fa-twitter',
            'linkedin.com' => 'fab fa-linkedin',
            'instagram.com' => 'fab fa-instagram',
            'youtube.com' => 'fab fa-youtube',
            'github.com' => 'fab fa-github',
            'reddit.com' => 'fab fa-reddit',
            't.co' => 'fab fa-twitter',
            'l.instagram.com' => 'fab fa-instagram',
        ];

        return $icons[$domain] ?? 'fas fa-external-link-alt';
    }

    /**
     * Get the color for the referrer
     */
    public function getReferrerColorAttribute()
    {
        $domain = $this->referrer_domain;

        $colors = [
            'direct' => 'gray',
            'google.com' => 'red',
            'facebook.com' => 'blue',
            'twitter.com' => 'sky',
            'linkedin.com' => 'blue',
            'instagram.com' => 'pink',
            'youtube.com' => 'red',
            'github.com' => 'gray',
            'reddit.com' => 'orange',
        ];

        return $colors[$domain] ?? 'purple';
    }
}