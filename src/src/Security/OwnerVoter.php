<?php

namespace App\Security;

// use App\Interface\OwnedInterface;

use App\Entity\Dorm;
use App\Entity\Hotel;
use App\Entity\User;
use App\Interface\OwnerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Psr\Log\LoggerInterface;
use SebastianBergmann\Environment\Console;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function PHPUnit\Framework\isEmpty;

class OwnerVoter extends Voter
{

 const VIEW = 'view';
 const NEW = 'new';
 const EDIT = 'edit';
 const Delete = 'delete'; 
 
 
protected function supports(string $attribute, $subject):bool
 {
  if (!in_array($attribute, [self::VIEW, self::EDIT, self::Delete, self::NEW])) {
    return false;
  }

// only vote on `Post` objects
  if (!$subject instanceof Dorm) {
    return false;
  }

  return true;
 }

 /**
  * @param string $attribute
  * @param OwnerInterface $subject
  * @param TokenInterface $token
  * @return bool
 */
 protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token):bool
 {
  $user = $token->getUser(); 
  if (!$user instanceof User) {
    return false;
  } 

  /** @var Dorm $dorm  */
  $dorm = $subject;

  switch ($attribute) {
    case self::VIEW:
        return $this->canView();
    case self::EDIT:
        return $this->canEdit($dorm, $user);  
    case self::NEW:
        return $this->canNew($subject, $user); 
    case self::Delete:
        return $this->canDelete($dorm, $user); 
    }
 }


/**
  * @return bool
 */
 public function canView(){ 
    return true;
 }
/**
  * @param Dorm $dorm
  * @param OwnerInterface $subject
  * @return bool
 */
 public function canEdit($dorm, $user){  
  return  ($dorm->getEditor() === $user || $dorm->getOwner() === $user);
 } 

/**
  * @param OwnerInterface $subject
  * @param User $user
  * @return bool
 */
  public function canNew($dorm, $user){ 
  return $dorm->getOwner() === $user;
  } 

  /**
  * @param Dorm $dorm
  * @param User $user
  * @param OwnerInterface $subject
  * @return bool
 */
 public function canDelete($dorm, $user){ 
  // die($dorm->getOwner());
  return ($dorm->getEditor() === $user || $dorm->getOwner() === $user);
 } 
}