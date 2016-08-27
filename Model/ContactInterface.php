<?php
namespace JT\ContactUsBundle\Model;

interface ContactInterface
{
    public function getName();
    public function getEmail();
    public function getSubject();
    public function getContent();
}