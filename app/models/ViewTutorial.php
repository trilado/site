<?php
/**
 * @Entity("view_tutorial") 
 */
class ViewTutorial extends Model
{
	/**
	 * @Column(Type="Int",Key="Primary")
	 */
	public $Id;
	
	/**
	 * @Column(Type="Int")
	 */
	public $Date;
	
	/**
	 * @Column(Type="Int")
	 */
	public $AuthorId;
	
	/**
	 * @Column(Type="String")
	 */
	public $Title;
	
	/**
	 * @Column(Type="String")
	 */
	public $Slug;
	
	/**
	 * @Column(Type="String")
	 */
	public $Content;
	
	/**
	 * @Column(Type="String")
	 */
	public $AuthorName;
	
	/**
	 * @Column(Type="String")
	 */
	public $AuthorEmail;
	
	
	/**
	 * @Column(Type="Int")
	 */
	public $AuthorLevel;
}