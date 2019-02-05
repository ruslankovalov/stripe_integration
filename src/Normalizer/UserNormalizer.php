<?php

namespace App\Normalizer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    const ACTION_KEY = 'action';
    const ACTION_REGISTRATION = 'registration';

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /* @var User $object*/
        return [
            'id' => $object->getId(),
            'email' => $object->getEmail(),
            'apiKey' => $object->getApiKey(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof User;
    }
}
