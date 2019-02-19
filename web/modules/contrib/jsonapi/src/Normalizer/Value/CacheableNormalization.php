<?php

namespace Drupal\jsonapi\Normalizer\Value;

use Drupal\Component\Assertion\Inspector;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Core\Cache\CacheableDependencyTrait;

/**
 * Use to store normalized data and its cacheability.
 *
 * @internal
 */
class CacheableNormalization implements CacheableDependencyInterface {

  use CacheableDependenciesMergerTrait;
  use CacheableDependencyTrait;

  /**
   * A normalized value.
   *
   * @var mixed
   */
  protected $normalization;

  /**
   * CacheableNormalization constructor.
   *
   * @param \Drupal\Core\Cache\CacheableDependencyInterface $cacheability
   *   The cacheability metadata for the normalized data.
   * @param array|string|int|float|bool|null $normalization
   *   The normalized data. This value must not contain any
   *   CacheableNormalizations.
   */
  public function __construct(CacheableDependencyInterface $cacheability, $normalization) {
    assert((is_array($normalization) && static::hasNoNestedInstances($normalization)) || is_string($normalization) || is_int($normalization) || is_float($normalization) || is_bool($normalization) || is_null($normalization));
    $this->normalization = $normalization;
    $this->setCacheability($cacheability);
  }

  /**
   * Gets the decorated normalization.
   *
   * @return array|string|int|float|bool|null
   *   The normalization.
   */
  public function getNormalization() {
    return $this->normalization;
  }

  /**
   * Gets a new CacheableNormalization with an additional dependency.
   *
   * @param \Drupal\Core\Cache\CacheableDependencyInterface $dependency
   *   The new cacheable dependency.
   *
   * @return static
   *   A new object based on the current value with an additional cacheable
   *   dependency.
   */
  public function withCacheableDependency(CacheableDependencyInterface $dependency) {
    return new static(static::mergeCacheableDependencies([$this, $dependency]), $this->normalization);
  }

  /**
   * Collects an array of CacheableNormalizations into a single instance.
   *
   * @param \Drupal\jsonapi\Normalizer\Value\CacheableNormalization[] $cacheable_arrays
   *   An array of CacheableNormalizations.
   *
   * @return static
   *   A new CacheableNormalization. Each input value's cacheability will be
   *   merged into the return value's cacheability. The return value's
   *   normalization will be an array of the input's normalizations. This method
   *   does *not* behave like array_merge() or NestedArray::mergeDeep().
   */
  public static function aggregate(array $cacheable_arrays) {
    assert(Inspector::assertAllObjects($cacheable_arrays, CacheableNormalization::class));
    return new static(
      static::mergeCacheableDependencies($cacheable_arrays),
      array_reduce(array_keys($cacheable_arrays), function ($merged, $key) use ($cacheable_arrays) {
        if (!$cacheable_arrays[$key] instanceof CacheableOmission) {
          $merged[$key] = $cacheable_arrays[$key]->getNormalization();
        }
        return $merged;
      }, [])
    );
  }

  /**
   * Ensures that no nested values are instances of this class.
   *
   * @param array|\Traversable $array
   *   The traversable object which may contain instance of this object.
   *
   * @return bool
   *   Whether the given object or its children have CacheableNormalizations in
   *   them.
   */
  protected static function hasNoNestedInstances($array) {
    foreach ($array as $value) {
      if ((is_array($value) || $value instanceof \Traversable) && !static::hasNoNestedInstances($value) || $value instanceof static) {
        return FALSE;
      }
    }
    return TRUE;
  }

}
