<?php

namespace Foundry\Core\Traits;

use Illuminate\Support\Collection;

/**
 * Trait Sluggify
 *
 * Create a unique slug for a given model
 *
 * @package Foundry\Traits
 *
 * @author Medard Ilunga
 *
 */
trait Sluggify {


	/**
	 * Get field name representing the slug, default slug
	 *
	 * @return string
	 */
	public function getSlugField() {
		return isset( $this->slug_field ) ?
			$this->slug_field :
			'slug';
	}

	/**
	 * Get field name from which slug is to be created, default name
	 *
	 * @return string
	 */
	public function getSluggableField() {
		return isset( $this->sluggable ) ?
			$this->sluggable :
			'name';
	}

	/**
	 * Laravel Model Boot function
	 */
	protected static function bootSluggify() {
		static::creating( function ( $model ) {
			/**@var $model Sluggify */
			$model[ $model->getSlugField() ] = $model->createSlug( $model[ $model->getSluggableField() ] );
		} );
	}

	/**
	 * Create a new slug
	 *
	 * @param $sluggable
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function createSlug( $sluggable ) {
		//Create slug
		$slug  = str_slug( $sluggable );
		$field = $this->getSlugField();
		// Get any that could possibly be related.
		$allSlugs = $this->getRelatedSlugs( $slug, $field );
		// If we haven't used it before then we are all good.
		/**@var $allSlugs Collection */
		if ( ! $allSlugs->contains( $field, $slug ) ) {
			return $slug;
		}
		// Just append numbers until we find one not used.
		for ( $i = 1; $i <= 1000; $i ++ ) {
			$newSlug = $slug . '-' . $i;
			if ( ! $allSlugs->contains( $field, $newSlug ) ) {
				return $newSlug;
			}
		}

		throw new \Exception( 'Can not create a unique slug' );
	}

	/**
	 * Get models with given slug
	 *
	 * @param $slug
	 * @param $field
	 *
	 * @return mixed
	 */
	private function getRelatedSlugs( $slug, $field ) {
		$query = static::withTrashed()->select( $field )->where( $field, 'like', $slug . '%' );

		if ( isset( $this->id ) ) {
			$query->where( 'id', '!=', $this->id );
		}

		return $query->get();
	}

}
