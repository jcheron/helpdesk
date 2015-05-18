<?php
/**
 * Représente un message
 * @author jcheron
 * @version 1.1
 * @package helpdesk.models
 */
class Message extends Base{
	/**
	 * @Id
	 */
	private $id;
	private $date;
	private $contenu;
	/**
	 * @ManyToOne
	 * @JoinColumn(name="idUser",className="User",nullable=false)
	 */
	private $user;
	/**
	 * @ManyToOne
	 * @JoinColumn(name="idTicket",className="Ticket",nullable=false)
	 */
	private $ticket;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id=$id;
		return $this;
	}

	public function getDate() {
		return $this->date;
	}

	public function setDate($date) {
		$this->date=$date;
		return $this;
	}

	public function getContenu() {
		return $this->contenu;
	}

	public function setContenu($contenu) {
		$this->contenu=$contenu;
		return $this;
	}

	public function getUser() {
		return $this->user;
	}

	public function setUser($user) {
		$this->user=$user;
		return $this;
	}

	public function getTicket() {
		return $this->ticket;
	}

	public function setTicket($ticket) {
		$this->ticket=$ticket;
		return $this;
	}

	/* (non-PHPdoc)
	 * @see Base::toString()
	 */
	public function toString() {
		return $this->ticket."-".$this->user;
	}
}