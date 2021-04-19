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
      'title' => $this->t('Lowest value (minimum)'),
      'method' => 'opMinimum',
      'short' => $this->t('minimum'),
      'values' => 2,
    ];
    $operators['maximum'] = [
      'title' => $this->t('Highest value (maximum)'),
      'method' => 'opMaximum',
      'short' => $this->t('Maximum'),
      'values' => 2,
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
    $expression = $this->buildExpression();
    $this->query->addWhereExpression($this->options['group'], $field_name . ' IN (SELECT MIN(' . $field_name . ') FROM ' . $this->tableAlias . $expression . ')');
  }

  /**
   * Filters by Maximum value.
   *
   * @param mixed $field
   *   The field.
   */
  protected function opMaximum($field) {
    $field_name = "$this->tableAlias.$this->realField";
    $expression = $this->buildExpression();
    $this->query->addWhereExpression($this->options['group'], $field_name . ' IN (SELECT MAX(' . $field_name . ') FROM ' . $this->tableAlias . $expression . ')');
  }

  /**
   * Build expression based on submitted values.
   *
   * @return string
   *   The expression.
   */
  protected function buildExpression() {
    $expression = '';
    if ($this->value['min'] && $this->value['max']) {
      $expression = ' WHERE ' . $this->value['min'] . ' = ' . $this->value['max'];
    }
    elseif ($this->value['min']) {
      $expression = ' GROUP BY ' . $this->value['min'];
    }
    return $expression;
  }

}
