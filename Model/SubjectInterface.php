<?php
namespace JT\ContactUsBundle\Model;

interface SubjectInterface
{
    public function getLabel();
    public function getTo();
}