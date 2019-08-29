<?php

namespace Drupal\views_filters_extras\Plugin\views\filter;

use Drupal\views\Plugin\views\filter\NumericFilter;

/**
 * Extend Numeric filter to include min and max operations.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("views_filters_extras_numeric")
 */
class ViewsFiltersExtrasNumericFilter extends NumericFilter {

  /**
   * {@inheritdoc}
   *
   * @return array
   *   Array of operators.
   */
  public function operators() {
    $operators = parent::operators();
    $operators['minimum'] = [
      'title' => $this->t('Lowest value (minimum'),
      'method' => 'opMinimum',
      'short' => $this->t('minimum'),
      'values' => 1,
    ];
    $operators['maximum'] = [
      'title' => $this->t('Highest value (maximum)'),
      'method' => 'opMaximum',
      'short' => $this->t('Maximum'),
      'values' => 1,
    ];

    return $operators;
  }

  /**
   * Filters by Minimum value.
   *
   * @param mixed $field
   *   The field.
   */
  protected function opMinimum($field) {
    $field_name = "$this->tableAlias.$this->realField";
    $this->query->addWhereExpression($this->options['group'], $field_name . ' IN (SELECT MIN(' . $field_name . ') FROM ' . $this->tableAlias . ' GROUP BY ' . $this->value['value'] . ')');
  }

  /**
   * Filters by Maximum value.
   *
   * @param mixed $field
   *   The field.
   */
  protected function opMaximum($field) {
    $field_name = "$this->tableAlias.$this->realField";
    $this->query->addWhereExpression($this->options['group'], $field_name . ' IN (SELECT MAX(' . $field_name . ') FROM ' . $this->tableAlias . ' GROUP BY ' . $this->value['value'] . ')');
  }

}
