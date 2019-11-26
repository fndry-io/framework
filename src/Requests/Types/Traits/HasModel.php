<?php

namespace Foundry\Requests\Types\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasModel {

    /**
     * @var Model
     */
    protected $model;

    /**
     * @return Model
     */
    public function getModel(): Model {
        return $this->model;
    }

    /**
     * @param Model|null $model
     *
     * @return $this
     */
    public function setModel( Model &$model = null ) {
        $this->model = $model;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasModel(): bool {
        return ! ! ( $this->model );
    }

    public function isFillable() {
        if ( $this->hasModel() ) {
            return $this->getModel()->isFillable( $this->getName() );
        }

        return true;
    }

    public function isVisible() {
        if ( $this->hasModel() ) {
            $hidden  = $this->getModel()->getHidden();
            $visible = $this->getModel()->getVisible();
            if ( ! $this->isHidden() && in_array( $this->getName(), $visible ) ) {
                return true;
            } elseif ( in_array( $this->getName(), $hidden ) ) {
                return false;
            }
        }

        return true;
    }

    public function isHidden() {

        if ( $this->hasModel() ) {

            $hidden = $this->getModel()->getHidden();

            if(strpos($this->getName(), '.') > 0){

                $annotations = explode('.', $this->getName());
                $relations = $this->getModel()->getRelations();

                return $this->hisRelatedFieldHidden($hidden, $annotations, $relations);

            }else{
                if ( in_array( $this->getName(), $hidden ) ) {
                    return true;
                }
            }
        }
        return false;
    }


    private function hisRelatedFieldHidden(array $hidden, array $annotations, array $relations)
    {
        $hide = false;

        if(isset($relations[$annotations[0]])){

            for ($i = 0, $j = 1; $j < sizeof($annotations); $i++, $j++){

                $hide = in_array($annotations[$i], $hidden);

                if(!$hide){
                    if (isset($relations[$annotations[$i]])){
                        $related = $relations[$annotations[$i]];
                        $hidden = method_exists($related, 'getHidden')?
                            $related->getHidden(): [];
                        $hide = in_array($annotations[$j], $hidden);
                    }
                }

            }

        }

        return $hide;
    }

}
